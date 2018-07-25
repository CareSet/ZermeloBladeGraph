# ZermeloBladeGraphBlade
Blade based D3 Graph view for Zermelo reporting engine

How to get started using it
-------------------------

### Installation
1. On a working Laravel 5.5+ instance with [Zermelo](https://github.com/CareSet/Zermelo) installed, append the following
to the "repositories" section of your composer.json file so composer can find the package on Github:
```
    , 
    {
        "type": "git",
        "url": "https://github.com/CareSet/ZermeloBladeGraph.git"
    }
```        
2. Then run this command prompt at your project root, type:
    `composer require careset/zermelobladegraph`
3. Then run:   
    `php artisan install:zermelobladegraph`
    This will create a zermelo directory in your resources directory containing blade view templates. 
    This will also publish the configuration file to your app's config directory, move assets (js, css) to public/vendor.  
4. Make sure your database is configured in .env or your app's database.php config. 

### Running Example
There is a sample DB table and sample report in the example directory. To use, import the example.sql file into your 
configured database. Then copy the example report into your app/Reports directory. You will need to create this 
directory if it does not exist. If your app already has an App\Reports namespace and directory, you can change the 
REPORT_NAMESPACE config in config/zermelo.php to something else like "Zermelo" and then create an app/Zermelo directory 
to place your example report in. Note: you will also need to change the namespace of ExampleReport to "namespace 
App\Zermelo;" if you change the REPORT_NAMESPACE.

### To access your web routes (default):

Displays d3 graph view
``` [base_url]/ZermeloGraph/[ReportClassName]```

Example Report d3 graph view
``` [base_url]/ZermeloGraph/ExampleReport```

### NOTES
This package automatically requires the Zermelo package as a dependency. You will nedd to follow the zermelo
installation instructions on how to subclass ZermeloReport and configure your app to use zermelo.
