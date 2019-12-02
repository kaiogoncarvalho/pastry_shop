<?php

namespace App\Services;


use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ClientsService
 * @package App\Services
 */
class ClientsService
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $fields
     * @return Client
     */
    public function create(array $fields): Client
    {
        return Client::create($fields);
    }

    /**
     * @param int $id
     * @param array $fields
     */
    public function update(int $id, array $fields): Client
    {
        /**
         * @var Client $client
         */
        $client = Client::findOrFail($id);

        if(array_key_exists('name', $fields)){
            $client->name = $fields['name'];
        }

        if(array_key_exists('email', $fields)){
            $client->email = $fields['email'];
        }

        if(array_key_exists('postcode', $fields)){
            $client->postcode = $fields['postcode'];
        }

        if(array_key_exists('address', $fields)){
            $client->address = $fields['address'];
        }

        if(array_key_exists('neighborhood', $fields)){
            $client->neighborhood = $fields['neighborhood'];
        }

        if(array_key_exists('phone', $fields)){
            $client->phone = $fields['phone'];
        }

        if(array_key_exists('birthdate', $fields)){
            $client->birthdate = $fields['birthdate'];
        }

        if(array_key_exists('complement', $fields)){
            $client->complement = $fields['complement'];
        }

        $client->save();

        return $client;
    }

    public function getAll(?array $filters)
    {
        $table = $this->client->getTable();
        $clients = DB::table($table);

        if(array_key_exists('name', $filters)){
            $clients->whereRaw("name like '%{$filters['name']}%'");
        }

        if(array_key_exists('email', $filters)){
            $clients->where('email', $filters['email']);
        }

        if(array_key_exists('phone', $filters)){
            $clients->where('phone', $filters['phone']);
        }

        if(array_key_exists('birthdate', $filters)){
            $clients->where('birthdate', $filters['birthdate']);
        }

        if(array_key_exists('postcode', $filters)){
            $clients->where('postcode', $filters['postcode']);
        }
        $clients->where('deleted_at', null);

        $clients->orderBy($filters['order'] ?? 'created_at');

        $fillable = $this->client->getFillable();
        $hidden = $this->client->getHidden();

        return $clients->paginate(
            $filters['perPage'] ?? 10,
            array_diff($fillable, $hidden),
            'page',
            $filters['page'] ?? 1
        );
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function delete(int $id): void
    {
        /**
         * @var Client $client
         */
        $client = Client::findOrFail($id);
        $client->delete();
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function get(int $id): Model
    {
        /**
         * @var Client $client
         */
        return Client::findOrFail($id);
    }

}
