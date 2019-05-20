<?php

namespace App\Http\Controllers;

use App\Exports\BaseExport;
use App\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\DataTables;

class BaseController extends Controller
{
    protected $crud;
    protected $entity;
    protected $model;
    protected $user;

    /**
     * Create a controller instance.
     *
     * @param Model $entity
     * @param bool $user
     */
    protected function __construct(Model $entity, $user = false)
    {
        $this->entity = $entity;
        $this->crud = $this->entity->getTable();
        $this->model = $this->entity->get()->sortBy('name');
        $this->user = $user;
        $this->middleware('ajax')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|View|BinaryFileResponse
     * @throws Exception
     */
    protected function index(Request $request)
    {
        if ($request->input('download'))return $this->download();
        else if ($request->ajax()) return Datatables::of($this->model)->make(true);
        else return view('app.index')->with(array_merge(array_merge([
            'crud' => $this->crud,
            'title' => __('app.titles.' . $this->crud),
            'subtitle' => __('app.titles.' . $this->crud),
        ], $this->entity->getLayout()), $request->input('data') ?? []));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    protected function show(int $id)
    {
        return response()->json($this->entity->find($id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FormRequest $request
     * @param bool $reload
     * @return Response
     */
    protected function storeBase(FormRequest $request, $reload = false)
    {
        $entity = $this->entity->create($request->all());

        if ($this->user) {
            $className = get_class($this->entity);

            User::create(array_merge($request->all(), [
                'name' => $entity->full_name,
                'model_type' => $className,
                'model_id' => $entity->id,
                'password' => bcrypt($entity->full_name),
            ]))->assignRole($this->crud);
        }

        return response()->json([
            'data' => $entity,
            'message' => __('base.messages.store', ['name' => $entity->fullName]),
            'reload' => $reload,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FormRequest $request
     * @param int $id
     * @return Response
     */
    protected function updateBase(FormRequest $request, int $id)
    {
        $entity = $this->entity->find($id)->fill($request->all());
        $entity->save();

        if ($this->user) {
            $className = get_class($this->entity);

            $user = User::where([['model_type', $className], ['model_id', $entity->id]])->first();
            $user->fill(array_merge($request->all(), [
                'name' => $entity->full_name,
            ]))->save();
        }

        return response()->json([
            'data' => $entity,
            'message' => __('base.messages.update', ['name' => $entity->full_name]),
        ]);
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $entity = $this->entity->find($id);

        $entity->delete();

        return response()->json([
            'message' => __('base.messages.delete', ['name' => $entity->full_name]),
        ]);
    }

    /**
     * Download a listing of the resource.
     *
     * @return BinaryFileResponse
     */
    public function download()
    {
        $collection = collect($this->model);
        $fields = $this->entity->getExport();
        $title = $this->entity->getTable();
        $format = 'xlsx';
        $fileName = config('app.name') . ' - ' . __('app.titles.' . $this->entity->getTable()) . ' - ' . date("Y-m-d H_i_s") . '.' . $format;

        return (new BaseExport($collection, $fields, $title))->download($fileName);
    }
}
