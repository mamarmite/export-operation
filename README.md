# ExportAllOperation

Current version 0.0.1

## Installation
`php artisan vendor:publish --provider="Backpack\ExportAllOperation\ExportOperationServiceProvider"`

## Features
- Export all to excel button added to the CRUD list view.


## Next features
Nice or idea to develop

- Export All to *choice* like datatable offers but without the max data limit of it.

https://github.com/yajra/laravel-datatables-export

https://github.com/Laravel-Backpack/CRUD/issues/3860



Originally posted by tabacitu April 13, 2020
Instead of using DataTable's magic to export rows, we should create an Export operation. That way:

    we could even customize how it's done, add different export formats, etc;
    it would fix the problem of having to see all entries that are exported (known limitation of the DataTables export when using AJAX);

The way I see it:

    the operation adds a single "Export" button to the bottom stack;
    click the button and it opens a modal; in that modal, you can
        choose which columns to show in the export;
        (maybe) reorder the columns in the export;
        choose the export format (XLS, CSV, PDF);
        choose to export:
            All rows (124.141 entries)
            Filtered rows (45.133 entries)
            Currently visible rows (25 rows)
            Currently selected rows (5 rows)
        click "Download" and you get the file you want; the file itself is generated using PHP generators, so that you can export even millions of rows;