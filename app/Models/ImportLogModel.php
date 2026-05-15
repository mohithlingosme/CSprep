<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class ImportLogModel extends Model
{
    protected string $table = 'imports';

    protected array $fillable = [
        'module_name',
        'file_name',
        'records_imported',
        'status',
        'notes',
    ];
}
