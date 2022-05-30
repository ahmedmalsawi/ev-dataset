<?php
function lang($phrase){
static $lang=array(
    'Language'          => 'Language',
    'Admin'             => 'Administrator',  //Dashboard phrases
    'Home'              =>'Home',
    'Categories'        =>'Categories',
    'Settings'          =>'Settings',
    'Edit Profile'      =>'Edit Profile',
    'Logout'            =>'Logout',
    'Items'             =>'Items',
    'members'           =>'Members',
    'Statistics'        =>'Statistics',
    'Logs'              =>'Logs',
    'Dashboard'         =>'Dashboard',
    'username'          =>'Username',
    'password'          =>'Password',
    'email'             =>'Email',
    'fullName'          =>'Full Name',
    'Edit Member'       =>'Edit Member',
    'Update'            =>'Update',
    'Update Member'     =>'Update Member',
    'Add Member'        =>'Add Member',
    'Delete Member'     =>'Delete Memberr',
    'Activate Member'   =>'Activate Memberr',
    
    
    
    
);
return $lang[$phrase];
}
