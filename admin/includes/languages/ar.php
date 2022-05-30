<?php
function lang($phrase){
static $lang=array(
    'Language'      => 'اللغة',
    'Admin'         => 'المدير',
    //NavBar phrases
    'Home'          =>'الرئيسية',
    'Categories'    =>'الموضوعات',
    'Settings'      =>'الاعدادات',
    'Edit Profile'  =>'الملف الشخصي',
    'Logout'        =>'الخروج',
    'Items'         =>'المنتجات',
    'members'       =>'الاعضاء',
    'Statistics'    =>'الاحصائيات',
    'Logs'          =>'السجلات',
    'Dashboard'     =>'لوحة التحكم',
    'username'      =>'اسم المستخدم',
    'password'      =>'كلمة المرور',
    'email'         =>'البريد الالكتروني',
    'fullName'      =>'الاسم الكامل',
    'Edit Member'   =>'تعديل المستخدم',
    
    
    
);
return $lang[$phrase];
}





