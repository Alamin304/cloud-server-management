<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ip_address',
        'provider',
        'status',
        'cpu_cores',
        'ram_mb',
        'storage_gb'
    ];

    protected $casts = [
        'cpu_cores' => 'integer',
        'ram_mb' => 'integer',
        'storage_gb' => 'integer',
    ];

    public static function validationRules($id = null)
    {
        return [
            'name' => 'required|string|max:255|unique:servers,name,' . $id . ',id,provider,' . request('provider'),
            'ip_address' => 'required|ipv4|unique:servers,ip_address,' . $id,
            'provider' => 'required|in:aws,digitalocean,vultr,other',
            'status' => 'required|in:active,inactive,maintenance',
            'cpu_cores' => 'required|integer|between:1,128',
            'ram_mb' => 'required|integer|between:512,1048576',
            'storage_gb' => 'required|integer|between:10,1048576',
        ];
    }

    public static function validationMessages()
    {
        return [
            'name.unique' => 'The server name already exists for this provider.',
            'ip_address.unique' => 'The IP address is already in use.',
            'ip_address.ipv4' => 'The IP address must be a valid IPv4 address.',
            'provider.in' => 'The selected provider is invalid.',
            'status.in' => 'The selected status is invalid.',
            'cpu_cores.between' => 'CPU cores must be between 1 and 128.',
            'ram_mb.between' => 'RAM must be between 512 MB and 1,048,576 MB (1 TB).',
            'storage_gb.between' => 'Storage must be between 10 GB and 1,048,576 GB (1 PB).',
        ];
    }
}
