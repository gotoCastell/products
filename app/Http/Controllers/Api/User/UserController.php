<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Models\Prospect;
use App\Models\UserCustomer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use App\Classes\Eloquent\Domain\Model\BaseModel;
use Symfony\Component\HttpFoundation\Response as HTTPCODE;

class UserController extends ApiController
{

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = User::query();

            if (isset($request->search)) {
                $user = $user->where('name', 'like', '%' . $request->search . '%');
            }
            if (isset($request->paginate)) {
                $user = $user->paginate($request->pageSize);
            } else {
                $user = $user->get();
            }

            $this->setDescriptionApiResponse('List users');
            return $this->response($user);
        } catch (\Throwable $th) {
            $this->setClassErrorLog(get_class($this));
            $this->setClassErrorLog('collection');

            $this->setDescriptionApiResponse('List users error');
            return $this->handleError([
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'messages' => $th->getMessage()
            ]);
        }
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            $user = User::find($id);
            $this->setDescriptionApiResponse('Show user');
            return $this->response($user);
        } catch (\Throwable $th) {
            $this->setClassErrorLog(get_class($this));
            $this->setClassErrorLog('show');

            $this->setDescriptionApiResponse('Show user error ');
            return $this->handleError([
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'messages' => $th->getMessage()
            ]);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $this->validation_rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];

            if (!$this->validator()) {
                $this->setDescriptionApiResponse('Por favor envíe todos los campos requeridos.');
                return $this->handleError($this->validator_errors, HTTPCODE::HTTP_UNPROCESSABLE_ENTITY);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            DB::commit();
            $this->setDescriptionApiResponse('User created!');
            return $this->response($user);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->setDescriptionApiResponse('User error');
            return $this->handleError([
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'messages' => $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            $this->validation_rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];

            Log::debug($this->validation_rules);
            Log::debug($id);
            Log::debug($request->all());
            Log::debug($this->name);

            if (!$this->validator()) {
                $this->setDescriptionApiResponse('Por favor envíe todos los campos requeridos.');
                return $this->handleError($this->validator_errors, Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            DB::beginTransaction();


            $user = User::find($id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            Log::debug($user);
            DB::commit();

            $this->setDescriptionApiResponse('User updated!');
            return $this->response($user);
        } catch (\Throwable $th) {
            DB::rollback();
            $this->setClassErrorLog(get_class($this));
            $this->setClassErrorLog('update');
            $this->setDescriptionApiResponse('User update error');
            return $this->handleError([
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'messages' => $th->getMessage()
            ]);
        }
    }

    public function destroy(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        try {

            $user = User::find($id);
            if (isset($user)) {
                DB::beginTransaction();
                $user->delete();
                DB::commit();
            }

            $this->setDescriptionApiResponse('User deleted!');
            return $this->response(null);
        } catch (\Throwable $th) {
            DB::rollback();

            $this->setClassErrorLog(get_class($this));
            $this->setClassErrorLog('destroy');

            $this->setDescriptionApiResponse('User delete error');
            return $this->handleError([
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'messages' => $th->getMessage()
            ]);
        }
    }
}
