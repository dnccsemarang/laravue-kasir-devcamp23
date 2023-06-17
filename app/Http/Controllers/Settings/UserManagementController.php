<?php


namespace App\Http\Controllers\Settings;


use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\User\CreateUserRequest;
use App\Http\Requests\Settings\User\UpdateUserRequest;
use App\Http\Resources\Settings\User\SubmitUserResource;
use App\Http\Resources\Settings\User\UserListResource;
use App\Models\User;
use App\Services\Settings\User\UserManagementService;
use Illuminate\Http\Request;
use Inertia\Inertia;


class UserManagementController extends Controller
{
    public function __construct(UserManagementService $userManagementService)
    {
        $this->userManagementService = $userManagementService;
    }

    public function index()
    {
        return Inertia::render('admin/settings/user/index', [
            "title" => 'POS | User managements',
            "additional" => [
                'role_list' => ''
            ]
        ]);
    }

    public function getData(Request $request)
    {
        try {
            $data = $this->userManagementService->getData($request);

            $result = new UserListResource($data);
            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function createData(CreateUserRequest $request)
    {
        try {
            $data = $this->userManagementService->createData($request);

            $result = new SubmitUserResource($data, 'User berhasil ditambahkan');

            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $data = $this->userManagementService->deleteData($id);
            $result = new SubmitUserResource($data, 'User berhasil dihapus');

            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function updateData(UpdateUserRequest $request, $id)
    {
        try {

            $data = $this->userManagementService->updateData($request,$id);

            $result = new SubmitUserResource($data, 'User berhasil diubah');

            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
}
