<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Product;
use App\Models\Store;
use App\Models\Manufacturer;
use App\Models\Category;
use App\Models\ContentManagement;
use App\Models\Question;
use App\Models\Social;
use App\Models\SubscribedUser;
use App\Models\UserQuestion;
use App\Models\Catalogue;
use Carbon\Carbon;
use Dotenv\Util\Str;
use GuzzleHttp\Handler\Proxy;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Type\Integer;

class PageController extends Controller
{
    public function dashboard()
    {
        $products = Product::with('store')->get();
        return view('dashboard', compact('products'));
    }

    public function content()
    {
        $content = ContentManagement::all();
        $socials = Social::all();
        return view('content', compact('content', 'socials'));
    }
    public function updateContent(Request $request)
    {
        $contentID = $request->id;
        $content = ContentManagement::find($contentID);
        $content->title = $request->title;
        $content->content  = $request->content;
        $content->save();
        return response()->json([
            'status' => 'true', 'message' => 'Content updated successfully',

        ]);
    }
    public function updateSocials(Request $request)
    {
        $data = $request->all();
        $social = Social::find($request->id);
        $social->email = $data['email'];
        $social->facebook = $data['facebook'];
        $social->instagram = $data['instagram'];
        $social->twitter = $data['twitter'];
        $social->save();
        return response()->json([
            'status' => 'true', 'message' => 'Socials updated successfully',
        ]);
    }

    public function showFAQs()
    {
        $questions = Question::all();
        return view('faqs', compact('questions'));
    }

    public function createFAQs(Request $request)
    {
        $data = [
            'question' => $request->question,
            'answer' => $request->answer
        ];

        Question::create($data);

        return back()->with('success', 'Data created successfully!');
    }

    public function updateFAQs(Request $request)
    {
        $question = Question::find($request->id);

        $data = [
            'question' => $request->question,
            'answer' => $request->answer
        ];

        $question->update($data);

        return redirect()->route('faqs');
    }

    public function deleteFAQs(string $id)
    {
        $question = Question::find($id);

        $question->delete();

        return redirect()->route('faqs');
    }

    public function showUserQuestions()
    {
        $user_questions = UserQuestion::where('answered', false)->get();
        return view('user-questions', compact('user_questions'));
    }

    public function deleteUserQuestion(string $id)
    {
        $question = UserQuestion::find($id);

        $question->delete();

        return redirect()->route('user-questions');
    }

    public function answerUserQuestion(Request $request)
    {
        $data = $request->all();
        $questionId = $data['id'];
        $question = UserQuestion::find($questionId);
        $question->answered = true;
        $question->save();

        $data = [
            'question' => $request->question,
            'answer' => $request->answer
        ];

        Question::create($data);

        return response()->json([
            'status' => 'true', 'message' => 'Socials updated successfully',
        ]);
    }
    public function saveData(Request $request)
    {
        $request->validate([
            'excel' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('excel');
        $filePath = $file->getRealPath();


        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Get the headers from the first row
        $headerRow = $sheet->getRowIterator(1, 1)->current();
        $headerCells = $headerRow->getCellIterator();
        $headerCells->setIterateOnlyExistingCells(false);

        $headers = [];
        foreach ($headerCells as $cell) {
            $headers[] = $cell->getValue();
        }

        // Get the data starting from the second row
        foreach ($sheet->getRowIterator(2) as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $rowData = [];
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }

            // Map the data to the headers
            $data = array_combine($headers, $rowData);

            $discount_percentage = 0;
            if (!$data['DiscountedPrice'] == 0) {
                $discount_percentage = (int) round(($data['RegularPrice'] - $data['DiscountedPrice']) / $data['RegularPrice'] * 100);
            }


            // Get or create related records
            $store = Store::firstOrCreate(['title' => $data['Store']]);
            $manufacturer = Manufacturer::firstOrCreate(['title' => $data['Manufacturer']]);
            $category = Category::firstOrCreate(['title' => $data['Category']]);

            // Prepare data for the Product model
            $productData = [
                'product_name' => $data['ProductName'],
                'store_id' => $store->id,
                'regular_price' => $data['RegularPrice'],
                'discounted_price' => $data['DiscountedPrice'],
                'manufacturer_id' => $manufacturer->id,
                'product_url' => $data['ProductUrl'],
                'image_url' => $data['ImageUrl'],
                'in_stock' => $data['InStock'],
                'product_code' => $data['ProductCode'],
                'discount_percentage' => $discount_percentage,
                'category_id' => $category->id,
                'category_link' => $data['CategoryLink'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ];

            // Insert the data into the database
            Product::create($productData);
        }

        return back()->with('success', 'Data inserted successfully!');
    }

    public function getAllCategories()
    {
        $categories = Category::all();
        return response()->json(['categories' =>  $categories], 200);
    }


    public function getAllBrands()
    {
        $brands = Manufacturer::all();
        return response()->json(['brands' =>  $brands], 200);
    }

    public function getAllFAQs()
    {
        $faqs = Question::all();
        return response()->json(['faqs' =>  $faqs], 200);
    }


    public function getAllBlogs()
    {
        $blogs = Blog::where('public', true)->get();
        return response()->json(['blogs' =>  $blogs], 200);
    }

    protected function filterProductsByPriceRange($queryFilter, $price_range)
    {
        if ($price_range && str_contains($price_range, '_')) {
            $price_range = explode('_', $price_range);
            $min_price = (int) $price_range[0];
            $max_price = (int) $price_range[1];

            if ($min_price > $max_price) {
                return false;
            }

            // Filter products based on both conditions


            $filteredProducts = $queryFilter->where(function ($query) use ($min_price, $max_price) {
                $query->where(function ($query) use ($min_price, $max_price) {
                    $query->where('discounted_price', 0)
                        ->whereBetween('regular_price', [$min_price, $max_price]);
                })->orWhere(function ($query) use ($min_price, $max_price) {
                    $query->where('discounted_price', '<>', 0)
                        ->whereBetween('discounted_price', [$min_price, $max_price]);
                });
            });

            return $filteredProducts;
        }
    }

    public function getFilteredProducts(Request $request)
    {
        $perPage = 10;
        $filters = $request->all();

        // Start with a query builder instance
        $query = Product::with(['store', 'category', 'manufacturer']); // Eager load the relationships

        if (array_key_exists('category', $filters)) {
            $categoryId = $request->category;
            $query->where('category_id', $categoryId);
        }

        if (array_key_exists('discount', $filters)) {
            $discount = $request->discount;
            $query->where('discount_percentage', '>=', $discount);
        }

        if (array_key_exists('brand', $filters)) {
            $brandId = $request->brand;
            $query->where('manufacturer_id', $brandId);
        }

        if (array_key_exists('price_range', $filters)) {
            $price_range = $request->price_range;
            $query = $this->filterProductsByPriceRange($query, $price_range);
        }

        // Paginate the results
        $products = $query->paginate($perPage);

        return response()->json(['products' => $products], 200);
    }


    // public function getProductsByCategory(?string $categoryId = null)
    // {
    //     // Get the perPage value from the query string, defaulting to 10 if not present
    //     $perPage = 10;

    //     if ($categoryId) {
    //         // $categoryId = Category::where('title', $categoryName)->value('id');
    //         $products = Product::where('category_id', $categoryId)->paginate($perPage);
    //     } else {
    //         $products = Product::paginate($perPage);
    //     }

    //     return response()->json(['products' => $products], 200);
    // }

    // public function getProductsByBrand(?string $brandId = null)
    // {
    //     $perPage = 10;
    //     if ($brandId) {
    //         // $brandId = Manufacturer::where('title', $brandName)->value('id');
    //         $products = Product::where('manufacturer_id', $brandId)->paginate($perPage);
    //     } else {
    //         $products = Product::paginate($perPage);
    //     }

    //     return response()->json(['products' => $products], 200);
    // }





    // public function getDiscountedProducts(?string $discountPercentage = null)
    // {
    //     $perPage = 10;
    //     // Validate the discount percentage
    //     if ($discountPercentage !== null && !in_array($discountPercentage, [5, 10, 20])) {
    //         return response()->json(['error' => 'Invalid discount percentage'], 400);
    //     }

    //     // If no discount percentage is provided, return all products
    //     if ($discountPercentage === null) {
    //         $products = Product::paginate($perPage);
    //     } else {
    //         // Return products with the specified discount or more
    //         $products = Product::where('discount_percentage', '>=', $discountPercentage)->paginate($perPage);
    //     }

    //     return response()->json($products);
    // }

    // public function getProductsByPriceRange(Request $request)
    // {
    //     $price_range = isset($request->price_range) ? $request->price_range : '';
    //     $price_range = $request->price_range;
    //     if ($price_range && str_contains($price_range, '_')) {
    //         $price_range = explode('_', $request->price_range);
    //         $min_price  = (int)($price_range[0]);
    //         $max_price  = (int)($price_range[1]);

    //         if ($min_price > $max_price) {
    //             return response()->json(['error' => "Minimum price can't be bigger than maximum price!"], 400);
    //         }

    //         if ($min_price == $max_price || $max_price == 0) {
    //             $products = Product::all();
    //             return response()->json(['products' => $products], 200);
    //         }


    //         $productsWithDiscountedPriceZero = Product::where('discounted_price', 0)->get();

    //         $productsWithDiscountedPriceZeroFiltered = $productsWithDiscountedPriceZero->whereBetween('regular_price', [$min_price, $max_price])->toArray();

    //         $productsWithDiscountedPriceDifferentFromZero = Product::where('discounted_price', '!=', 0)->get();

    //         $productsWithDiscountedPriceDifferentFromZeroFiltered = $productsWithDiscountedPriceDifferentFromZero->whereBetween('discounted_price', [$min_price, $max_price])->toArray();

    //         $data = array_merge($productsWithDiscountedPriceZeroFiltered, $productsWithDiscountedPriceDifferentFromZeroFiltered);
    //         return response()->json($data);
    //     } else {
    //         $products = Product::all();
    //         return response()->json(['products' => $products], 200);
    //     }
    //     //?string $param = null
    //     //$min_price = null, ?string $max_price = null




    //     // $param = explode('&', $param);
    //     // $min_price  = (int)($param[0]);
    //     // $max_price  = (int)($param[1]);

    //     // if ($min_price == $max_price || $max_price == 0) {
    //     //     $products = Product::all();
    //     //     return response()->json(['products' => $products], 200);
    //     // }
    //     // if ($min_price > $max_price) {
    //     //     return response()->json(['error' => "Minimum price can't be bigger than maximum price!"], 400);
    //     // }
    //     // // Query products based on the price range

    // }

    // protected function filterProductsByPriceRange($products, $price_range)
    // {

    //     if ($price_range && str_contains($price_range, '_')) {
    //         $price_range = explode('_', $price_range);
    //         $min_price  = (int)($price_range[0]);
    //         $max_price  = (int)($price_range[1]);

    //         if ($min_price > $max_price) {
    //             // return response()->json(['error' => "Minimum price can't be bigger than maximum price!"], 400);
    //             return false;
    //         }

    //         if ($min_price == $max_price || $max_price == 0) {
    //             return $products;
    //         }


    //         $productsWithDiscountedPriceZero = $products->where('discounted_price', 0)->get();

    //         $productsWithDiscountedPriceZeroFiltered = $productsWithDiscountedPriceZero->whereBetween('regular_price', [$min_price, $max_price])->toArray();

    //         $productsWithDiscountedPriceDifferentFromZero = $products->where('discounted_price', '!=', 0)->get();


    //         $productsWithDiscountedPriceDifferentFromZeroFiltered = $productsWithDiscountedPriceDifferentFromZero->whereBetween('discounted_price', [$min_price, $max_price])->toArray();

    //         $data = array_merge($productsWithDiscountedPriceZeroFiltered, $productsWithDiscountedPriceDifferentFromZeroFiltered);
    //         return  $data;
    //     } else {
    //         return $products;
    //     }
    // }


    public function showSubscribedUsers()
    {
        $subscribed_users = SubscribedUser::all();
        return view('subscribed-users', compact('subscribed_users'));
    }
    public function subscribeUser(Request $request)
    {
        $user = $request->user();

        $data = [
            'user_id' => $user->id,
            'email' => $request->email,
        ];

        SubscribedUser::create($data);

        return response()->json(['status' =>  'User has subscribed successfully!']);
    }

    public function deleteSubscribedUser(string $id)
    {
        $subscribed_user = SubscribedUser::find($id);

        if ($subscribed_user) {
            $subscribed_user->delete();
            return redirect()->route('subscribed-users')->with(['status' => 'User has been unsubscribed successfully!']);
        }

        return redirect()->route('subscribed-users')->with(['status' => 'User not found.']);
    }

    public function blogs()
    {
        $blogs = Blog::all();
        return view('blogs', compact('blogs'));
    }

    public function postBlog(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|url',
            'link' => 'required|url',
            'public' => 'required|boolean',
            'description' => 'required|string',
        ]);

        Blog::create([
            'title' => $validatedData['title'],
            'image' => $validatedData['image'],
            'link' => $validatedData['link'],
            'public' => $validatedData['public'],
            'description' => $validatedData['description'],
        ]);

        return redirect()->back()->with('success', 'Blog post created successfully!');
    }

    public function deleteBlog(String $id)
    {

        $blog = Blog::find($id);
        $blog->delete();

        return redirect()->back()->with('success', 'Blog deleted successfully!')->with('scrollTo', 'blogsSection');
    }

    public function changeBlogStatus(String $id)
    {
        $blog = Blog::find($id);

        if ($blog->public == 1) {
            $blog->public = 0;
            $blog->save();
            return redirect()->back()->with('success', 'Blog has been set to Private!')->with('scrollTo', 'blogsSection');
        } else if ($blog->public == 0) {
            $blog->public = 1;
            $blog->save();
            return redirect()->back()->with('success', 'Blog has been set to Public!')->with('scrollTo', 'blogsSection');
        }
    }

    public function showCatalogues()
    {
        $catalogues = Catalogue::all();
        $stores = Store::all();
        return view('catalogues', compact('catalogues', 'stores'));
    }

    public function storeCatalogue(Request $request)
    {
        // Validate the form data
        $request->validate([
            'catalogue_name' => 'required|string|max:255',
            'catalogue_file_url' => 'required|file|mimes:pdf',
            'catalogue_pic_url' => 'required|file|image',
            'store_id' => 'required|exists:stores,id',
            'starting_period' => [
                'required',
                'date',
                'after:' . Date::now()->format('Y-m-d'), // Ensure the starting_period is after today
            ],
            'ending_period' => 'required|date|after_or_equal:starting_period',
        ]);

        $picture = $request->file('catalogue_pic_url');
        $pictureName = time() . '_' . $picture->getClientOriginalName();
        $picture->storeAs('catalogue_pictures', $pictureName, 'public');

        $file = $request->file('catalogue_file_url');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('catalogue_files', $fileName, 'public');

        $catalogue = new Catalogue();
        $catalogue->catalogue_name = $request->input('catalogue_name');
        $catalogue->catalogue_file_url = $fileName;
        $catalogue->catalogue_pic_url = $pictureName;
        $catalogue->store_id = $request->input('store_id');
        $catalogue->starting_period = $request->input('starting_period');
        $catalogue->ending_period = $request->input('ending_period');
        $catalogue->save();

        // Redirect back with success message
        return redirect()->back()->with('status', 'Catalogue added successfully!');
    }

    public function deleteCatalaogue(String $id)
    {

        $catalogue = Catalogue::find($id);
        $catalogue->delete();

        return redirect()->back()->with('status', 'Catalogue deleted successfully!');
    }


    public function changeCatalogueStatus(String $id)
    {
        $catalogue = Catalogue::find($id);

        if ($catalogue->is_public == 1) {
            $catalogue->is_public = 0;
            $catalogue->save();
            return redirect()->back()->with('success', 'Blog has been set to Private!');
        } else if ($catalogue->is_public == 0) {
            $catalogue->is_public = 1;
            $catalogue->save();
            return redirect()->back()->with('success', 'Blog has been set to Public!');
        }
    }

    public function getAllCatalogues()
    {
        $catalogues = Catalogue::where('is_public', true)->get();
        return response()->json(['catalogues' =>  $catalogues], 200);
    }


    // Login Admin user to get to Dashboard

    public function loginPage()
    {
        return view('login');
    }
}
