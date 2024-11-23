<?php 
return[
    [
        'icon'=>'nav-icon fas fa-tachometer-alt',
        'route'=>'dashboard.dashboard',
        'title'=>'Dashbaord',
        'active'=>'dashboard.dashboard'
    
    ],
    
    [
        'icon'=>'fas fa-list',
        'route'=>'dashboard.categories.index',
        'title'=>'Categories',
        'badge'=>'New',
        'active'=>'dashboard.categories.*'
    
    ],
    
    [
        'icon'=>'fas fa-recycle',
        'route'=>'dashboard.categories_trash',
        'title'=>'Trashed Categories',
        'active'=>'dashboard.categories_trash'
    ],
    
    [
        'icon'=>'fas fa-box',
        'route'=>'dashboard.products.index',
        'title'=>'Products',
        'active'=>'dashboard.products.*'
    ],
];