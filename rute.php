<?php
require_once 'helpers/url.php';
$segments = [];
for ($i = 0; $i < 20; $i++) {
    $seg = url_segment($i);
    if ($seg !== "") $segments[] = $seg;
}

// Definisi routes
$routes = [
    ""          => "Pages/index.php",
    "login"     => "Pages/login.php",
    "course-detail" => "Pages/course-detail.php",
    "dashboard" => [
        "" => "Pages/dashboardUser.php",
        "edit-profile" => "Pages/edit_profile.php",
    ],


    "course" => [
        "" => "Pages/course.php",
        ":courseId" => [
            "" =>  "Pages/learning_path.php",
            "detailModule" => [
                ":moduleId" =>  "Pages/module_content.php"
            ]
        ]
    ],

    "admin"     => [
        "dashboard" => "Pages/admin/dashboard-admin.php",
        "manajemen-kursus" => [
            "" => "Pages/admin/courseManagement/index.php",
            "tambah-kursus" => "Pages/admin/courseManagement/tambah-kursus.php",
        ],

        "manajemen-modul-konten" => [
            "" => "Pages/admin/moduleContentManagement/index.php",
            ":moduleId" => [
                "tambah-konten" => "Pages/admin/moduleContentManagement/tambah-modul-content.php",
            ],
            // "tambah-modul-content"=>"Pages/admin/moduleContentManagement/tambah-modul-content.php",
        ],
        "manajemen-modul" => [
            "" => "Pages/admin/moduleManagement/index.php",
            "tambah-modul" => "Pages/admin/moduleManagement/tambah_modul.php",
        ],
        "manajemen-pengguna" => [
            "" => "Pages/admin/userManagement/index.php",
        ],

        "user"      => [
            ""       => "Pages/admin/user.php",
            "edit"   => [
                ":id" => [
                    "" => "Pages/admin/userManagement/userEdit.php",
                    ":segment" => "Pages/admin/userManagement/segment.php",
                    "tes" => [
                        "" => "Pages/admin/userManagement/tes.php",
                        ":slug" => "Pages/admin/userManagement/slug.php"
                    ]
                ]
            ],
            "delete" => [
                ":id" => "Pages/admin/user_delete.php"
            ]
        ]
    ]
];

// Router function
function resolveRoute($routes, $segments, &$params = [])
{ // krena paramsnya make & jadi nialai variabel yg dimasukkan sebagai  argumen ikut terupdate langsung . jdi bukan salinan saja
    $current = $routes;

    foreach ($segments as $seg) {
        if (isset($current[$seg])) {
            $current = $current[$seg]; // exact match
        } else {
            // cek param route (:id, :slug, dll)
            foreach ($current as $key => $val) {
                if (strpos($key, ":") === 0) {
                    $paramKey = substr($key, 1); //misal ":id" -> ambil dari indeex 1 yaitu "id"
                    $params[$paramKey] = $seg; //
                    $current = $val;
                    continue 2;
                }
            }
            return "Pages/404.php";
        }
    }

    if (is_array($current)) {
        return $current[""] ?? "Pages/404.php";
    }

    return $current;
}

// Eksekusi
$params = [];
$file = resolveRoute($routes, $segments, $params);

if (file_exists($file)) {
    include $file;
} else {
    include "Pages/404.php";
}


/*
===========================================
📜 ROUTE LIST — http://localhost/learnweb/
===========================================

# 🏠 PUBLIC ROUTES
[GET] /                            → Pages/index.php
[GET] /login                       → Pages/login.php
[GET] /dashboard                   → Pages/dashboard.php
[GET] /course-detail               → Pages/course-detail.php
[GET] /profile                     → Pages/user/profile.php
[GET] /setting                     → Pages/user/setting.php

# 📚 COURSE ROUTES
[GET] /course                      → Pages/course.php
[GET] /course/{courseId}           → Pages/learning_path.php

# 🛠️ ADMIN ROUTES
[GET] /admin/dashboard             → Pages/admin/dashboard-admin.php

## 🎓 Manajemen Kursus
[GET] /admin/manajemen-kursus                          → Pages/admin/courseManagement/index.php
[GET] /admin/manajemen-kursus/tambah-kursus            → Pages/admin/courseManagement/tambah-kursus.php

## 📦 Manajemen Modul
[GET] /admin/manajemen-modul                           → Pages/admin/moduleManagement/index.php
[GET] /admin/manajemen-modul/tambah-modul              → Pages/admin/moduleManagement/tambah_modul.php

## 🧩 Manajemen Modul Konten
[GET] /admin/manajemen-modul-konten                    → Pages/admin/moduleContentManagement/index.php
[GET] /admin/manajemen-modul-konten/{moduleId}/tambah-konten → Pages/admin/moduleContentManagement/tambah-modul-content.php

## 👥 Manajemen Pengguna
[GET] /admin/manajemen-pengguna                        → Pages/admin/userManag 

===========================================
*/
