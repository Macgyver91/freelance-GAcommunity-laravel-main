<?php

namespace App\Http\Controllers\Api\TypeLien;

use App\Http\Controllers\Controller;
use App\Models\TypeLien;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeLienController extends Controller
{

    use ApiResponser;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            'name' => 'required|string'
        ];
        $validator = Validator::make($request, $rule);

        if($validator->fails()) {
            return $this->error('Invalid data', 400);
        }

        try {
            $link_type = TypeLien::create([
                'name' => $request->name
            ]);
            return $this->success($link_type, 'TypeLien created successfully');
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return $this->error('An error occured when creating typeLien', 400);
            }
            return $this->error('An error occured, please try again', 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type_lien = TypeLien::find($id);
        return $this->success($type_lien, 'typeLien founded');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeLien $type_lien)
    {
        $rules = [
            'name' => 'required|string'
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $this->error('Invalid data', 400);
        }

        try {
            $type_lien->name = $request->name;
            $type_lien->save();

            return $this->success($type_lien, 'Link type updated successfully');
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return $this->error('An error occured when trying to update link type', 400);
            }
            return $this->error('An error occured, please try again', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeLien $type_lien)
    {
        $type_lien->delete();
        return $this->success($type_lien, 'Link type deleted successfully');
    }
}