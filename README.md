# ExportAllOperation

Current version 0.0.1

## Installation
Add the package into your structure. (no composer package yet)

`php artisan vendor:publish --provider="Backpack\ExportAllOperation\ExportOperationServiceProvider"`

## Features
- [X] Trait that add a button into you list view 
- [X] Creates URI endpoint to export all the model entries into a file.
  - [X] CSV (in plain php)
  - [ ] CSV with a lib (same as excel to DRY things)
  - [ ] Excel (Planned)
  - [ ] PDF (Maybe soon)
  - [ ] HTML (Maybe soon)


## Next features
Nice or idea to develop

- [ ] Add new permission precisely for this operation
- [ ] Choose which columns to show in the export
  - [ ] use DataTable UX ?
- [ ] (maybe) reorder the columns in the export
  - [ ] Use the Backpack for laravel reordering feature ?
- [ ] Choose what you export
  - All rows (124.141 entries)
  - Filtered rows (45.133 entries)
  - Currently visible rows (25 rows) (this DT have it covered I think)
  - Currently selected rows (5 rows) (this DT have it covered I think)
- Add a download btn with the format choices

## Explore other ways

This package add Livewire into
https://github.com/yajra/laravel-datatables-export


## Exporting to excel and other format

### Library I've checked :
- [maatwebsite/excel](https://github.com/SpartnerNL/Laravel-Excel) library. It's awesome. But it seem overly featured to my currents needs.
- [PHPOffice/phpspreadsheet](https://github.com/PHPOffice/phpspreadsheet/) It's a little bit too much for our needs, but it would give some shortcuts for making excel file a little bit sexyier.

## Origin story

### The features Originally posted by tabacitu April 13, 2020

https://github.com/Laravel-Backpack/CRUD/issues/3860

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