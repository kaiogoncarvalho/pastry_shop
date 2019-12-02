<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Pastry;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

/**
 * Class ClientsService
 * @package App\Services
 */
class PastriesService
{
    /**
     * @var Pastry
     */
    private $pastry;

    public function __construct(Pastry $pastry)
    {
        $this->pastry = $pastry;
    }

    /**
     * @param array $fields
     * @param $file
     * @return Pastry
     * @throws \Exception
     */
    public function create(array $fields, UploadedFile $file): Pastry
    {
        DB::beginTransaction();
        try {
            $fields['photo'] = $file->getClientOriginalName();
            $pastry = Pastry::create($fields);
            Storage::putFileAs("pastries/{$pastry->id}", $file, $pastry->photo);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return $pastry;
    }

    /**
     * @param int $id
     * @param array $fields
     */
    public function update(int $id, array $fields, ?UploadedFile $file): Pastry
    {
        /**
         * @var Pastry $pastry
         */
        $pastry = Pastry::findOrFail($id);
        DB::beginTransaction();
        try {
            $pastry->name = $fields['name'] ?? $pastry->name;
            $pastry->price = $fields['price'] ?? $pastry->price;

            if ($file instanceof UploadedFile) {
                Storage::deleteDirectory("pastries/$id");
                $pastry->photo = $file->getClientOriginalName();
                Storage::putFileAs("pastries/{$pastry->id}", $file, $pastry->photo);
            }


            $pastry->save();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return $pastry;
    }

    public function getAll(?array $filters)
    {
        $table = $this->pastry->getTable();
        $pastries = DB::table($table);

        if (array_key_exists('name', $filters)) {
            $pastries->whereRaw("name like '%{$filters['name']}%'");
        }
        $pastries->where('deleted_at', null);

        $pastries->orderBy($filters['order'] ?? 'created_at');

        $fillable = $this->pastry->getFillable();
        $hidden = $this->pastry->getHidden();

        return $pastries->paginate(
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
         * @var Pastry $pastry
         */
        $pastry = Pastry::findOrFail($id);
        $pastry->delete();
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function get(int $id): Pastry
    {
        return Pastry::findOrFail($id);
    }

    public function getPhoto(int $id)
    {
        $pastry = Pastry::findOrFail($id);
        return Storage::download("pastries/{$id}/{$pastry->photo}");
    }


}
