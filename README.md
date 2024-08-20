# BrainsterProject_BorcheKojikj_FS14
<a name="readme-top"></a>

<div align="center">
  <a href="#">
    <!-- <img src="{{ asset('images/logo.png') }}" alt="Logo" width="80" height="80"> -->
  </a>
  <h3 align="center">Kine Moe (Project 3) - Borche Kojikj FS14</h3>
</div>
<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#built-with">Built With</a>
    </li>
    <li>
      <a href="#about-the-project">About The Project</a>
    </li>
    <li>
      <a href="#installation">Installation</a>
    </li>
    <li>
      <a href="#usage">Usage</a>
    </li>
    <li>
      <a href="#contact">Contact</a>
    </li>
  </ol>
</details>
<h3 id="built-with">Built With:</h3>
<ul>
  <!-- https://shields.io/badges for creating readme file badges -->
  <li><img alt="HTML" src="https://img.shields.io/badge/-HTML5-e34c26?logo=html5&logoColor=white"/></li>
  <li><img alt="CSS" src="https://img.shields.io/badge/-CSS3-264de4?logo=css3&logoColor=white"/></li>
  <li><img alt="Bootstrap" src="https://img.shields.io/badge/-Bootstrap-CD6799?logo=bootstrap&logoColor=white"/></li>
  <li><img alt="JavaScript" src="https://img.shields.io/badge/-JavaScript-EFD81D?logo=javascript&logoColor=white"/></li>
  <li><img alt="PHP" src="https://img.shields.io/badge/-PHP-777BB4?logo=php&logoColor=white"/></li>
  <li><img alt="Laravel" src="https://img.shields.io/badge/-Laravel-FF2D20?logo=laravel&logoColor=white"/></li>
  <li><img alt="jQuery" src="https://img.shields.io/badge/-jQuery-0769AD?logo=jquery&logoColor=white"/></li>
</ul>
<h3 id="about-the-project">About The Project:</h3>
<p>
  KineMoe is a streaming service focused on Macedonian and Balkan cinematic works, featuring IMDb-like functionalities and social media aspects to promote regional culture and collaboration among artists and film enthusiasts.
</p>
<p>
  This repository contains the Admin Panel for managing the KineMoe platform, developed using Laravel with Eloquent ORM, JavaScript, jQuery, and HTML5.
</p>
<div>
  <p>Admin User:</p>
  <b>Username:</b> borche@gmail.com <br>
  <b>Password:</b> Test1234!
</div>
<br>
<h3>Key Features:</h3>
<h5>User Management</h5>
<ol>
  <li><b>View User Profiles:</b> Admins can view detailed user profiles, engagement metrics, and activity logs.</li>
  <li><b>Edit User Profiles:</b> Admins can update user information.</li>
  <li><b>Delete User Profiles:</b> Admins can delete user profiles with a confirmation step.</li>
  <li><b>Suspend/Unsuspend Users:</b> Admins can manage account status to handle misuse or violations.</li>
  <li><b>Assign Roles:</b> Admins can assign and manage user roles (Viewer, Artist, Moderator).</li>
  <li><b>Manage Permissions:</b> Admins can adjust permissions for each role.</li>
  <li><b>Track Engagement Metrics:</b> Admins can monitor user activities such as comments, discussions, and watch history.</li>
  <li><b>Award Points and Badges:</b> Admins can reward users for contributions or achievements.</li>
</ol>
<h5>Content Management</h5>
<ol>
  <li><b>Add New Content:</b> Admins can add movies, series, and podcasts, including detailed metadata.</li>
  <li><b>Edit Existing Content:</b> Admins can update content information.</li>
  <li><b>Delete Content:</b> Admins can remove content with a confirmation step.</li>
  <li><b>Content Categorization:</b> Admins can organize content by genres and categories.</li>
  <li><b>Schedule Releases:</b> Admins can set release dates and times for new content.</li>
  <li><b>Manage Upcoming Releases:</b> Admins can view and adjust the content release schedule.</li>
</ol>
<h5>Artist Management</h5>
<ol>
  <li><b>View Artist Profiles:</b> Admins can access detailed profiles of registered artists.</li>
  <li><b>Edit Artist Profiles:</b> Admins can update artist information.</li>
  <li><b>Verify Artists:</b> Admins can verify artist accounts and provide a verification badge.</li>
  <li><b>Track Artist Contributions:</b> Admins can manage artist content submissions and collaborations.</li>
</ol>
<h5>Community and Engagement</h5>
<ol>
  <li><b>Moderate Posts:</b> Admins can review, approve, edit, or delete community posts.</li>
  <li><b>Highlight Posts:</b> Admins can pin important posts for increased visibility.</li>
  <li><b>Moderate Comments:</b> Admins can manage comments on posts and content.</li>
  <li><b>Delete Inappropriate Comments:</b> Admins can remove comments that violate guidelines.</li>
  <li><b>Manage User Reports:</b> Admins can handle reports of inappropriate content or behavior.</li>
  <li><b>Take Action on Reports:</b> Admins can warn, suspend, or ban users and remove content based on reports.</li>
</ol>
<h5>System Settings</h5>
<ol>
  <li><b>General Settings:</b> Admins can configure platform settings including site name, logo, contact info, and terms of service.</li>
</ol>
<h3 id="installation">Installation</h3>
<ol>


  <li>From https://github.com/JulienRAVIA/FakerCinemaProviders
    <pre>
    <code>Run: composer require xylis/faker-cinema-providers</code>
    </pre>
  </li>
  <li>From https://github.com/laravel/ui
    <pre>
    <code>Run: 
      composer require laravel/ui </br>
   </code>
    <code>Run: 
      php artisan ui bootstrap --auth </br>
   </code>
    </pre>
  </li>

  <li>Start the development server:
    <pre>
    <code>php artisan serve</code>
    <code>npm run dev</code>
    </pre>
  </li>
</ol>
<h3 id="usage">Usage</h3>
<p>Access the admin panel at <code>http://localhost:8000/login</code> and log in with your admin credentials.</p>
<h3 id="contact">Contact</h3>
<ul>
    <li>Email: borcekojikj@gmail.com</li>
    <li>Telephone: +389 71 226 904</li>
    <li><a href="https://www.linkedin.com/in/borce-kojikj-349225208/">LinkedIn profile</a></li>
    <!-- <li><a href="https://github.com/yourusername">GitHub profile</a></li> -->
</ul>
<div align="right">
  <a href="#readme-top">back to top &#8593;</a>
</div>