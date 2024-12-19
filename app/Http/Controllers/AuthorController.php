<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Resources\AuthorResource;
use App\Traits\HasApiResponse;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;


class AuthorController extends Controller
{
    use HasApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $message = "Authors Retrieved Successfully";
        $data = AuthorResource::collection(Author::latest()->get());
        return $this->success($message,$data);
    }

    public function search(Request $request){
        $terms = $request->all();
        if(count($terms)){
            $query = Author::query();
            foreach($terms as $key=>$value){
                // $query->where($key,'like','%'.$value.'%');
                $query->orWhere($key,'like','%'.$value.'%');
            }

            $result = $query->get();

            if(count($result)){
                return $this->success(
                    "Search Results Retrieved Successfully",
                    AuthorResource::collection($result),
                );
            }
            else{
                return $this->error(
                    'Your Term Did not Return any Result',
                    404
                );
            }
        }
        else{
            return $this->error('No Search Term Provided',400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        $data = $request->validated();

        if($author = Author::create($data)){
            $message = "Author Created Successfully";
            $responseData = [
                'author'=>new AuthorResource($author)
            ];
            $code = 201;
            return $this->success($message,$responseData,$code);
        }
        else{
            $message = "An Error Occured,Please try again";
            $code=400;
            return $this->error($message,$code);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $author = Author::find($id);

        if($author){
            $message = "Single Author Retrieved";
            $responseData = new AuthorResource($author);
            return $this->success($message,$responseData);
        }
        else{
            $message = "Author not Found";
            $code=404;
            return $this->error($message,$code);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $data = $request->validated();

        if($author->update($data)){
            $responseData = new AuthorResource($author);
            return $this->success('Author Updated Successfully',$responseData,200);
        }
        else{
            return $this->error('An Error Occured, Please try again',400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $author = Author::find($id);
        if($author){
            if($author->delete()){
                $message = "Author Deleted Successfully";
                $data = [];
                return $this->success($message,$data);
            }
            else{
                return $this->error('An Error Occurred',400);
            }
        }
        else{
            return $this->error('Author does not Exist',404);
        }

    }
}
