<?php

namespace App\Http\Controllers;


use App\Models\CashBox;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class CashBoxController
 */
class CashBoxController extends Controller
{
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', []);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        /* @var $user User */
        $user = auth()->user();
        return response()->json($user->cashBoxes()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validateCashBox($request);

        $cashBox = new CashBox($request->all());

        if (!$cashBox->save()) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        /* @var $user User */
        $user = auth()->user();
        $cashBox->users()->attach($user->id);

        return response('', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(string $id)
    {
        $cashBox = $this->find($id);
        return response()->json($cashBox);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string $id
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function update(string $id, Request $request)
    {
        $this->validateCashBox($request);

        $cashBox = $this->find($id);
        if (!$cashBox->update($request->all())) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response('', Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return Response
     * @throws Exception
     */
    public function destroy(string $id)
    {
        $cashBox = $this->find($id);

        if (!$cashBox->delete()) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Request $request
     * @throws ValidationException
     */
    private function validateCashBox(Request $request): void
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'max:255',
        ]);
    }

    /**
     * @param int $id
     * @return CashBox|mixed
     * @throws AuthorizationException
     */
    private function find(int $id) {
        $cashBox = CashBox::find($id);
        Gate::authorize('cashBoxMember', $cashBox);
        return $cashBox;
    }
}
