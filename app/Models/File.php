<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
       /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'files'; // Only needed if your table name isn't the plural of the model name

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // Add all columns you want to be mass assignable
        'file_id',
        'original_file_name', 
        'input_file',
        'operation',
        'output_file_name',
        'date',
        'file',
        'status'
        // Add other columns from your files table
    ];


}
