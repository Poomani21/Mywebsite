<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function usersList(Request $request)
    {

        $columns = ['name', 'email', 'phone', 'role', 'created_at'];

        $query = User::query();

        if ($request->search['value']) {
            $search = $request->search['value'];

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            });
        }

        $totalData = $query->count();

        $orderColumn = $columns[$request->order[0]['column']];
        $orderDir = $request->order[0]['dir'];

        $users = $query
            ->orderBy($orderColumn, $orderDir)
            ->skip($request->start)
            ->take($request->length)
            ->get();

        $data = [];

        foreach ($users as $user) {

            $image = asset('images/' . $user->image);

            $data[] = [

                'checkbox' => '<input type="checkbox" class="userCheckbox" value="' . $user->_id . '">',

                'image' => "<img src='$image' width='42' height='42' style='object-fit:cover' class='rounded-circle'>",

                'name' => $user->name,

                'email' => $user->email,

                'phone' => $user->phone,

                'role' => $user->role,

                'login' => $user->login_device['browser'] ?? '',

                'location' => ($user->login_device['city'] ?? '') . ',' .
                    ($user->login_device['country'] ?? ''),

                'created_at' => $user->created_at->format('d M Y'),

                'action' => '
                <div style="display:flex;gap:6px">
                <button class="btn btn-primary btn-sm viewUser" data-id="' . $user->_id . '">
                <i class="bi bi-eye"></i>
                </button>

                <button class="btn btn-danger btn-sm deleteUser" data-id="' . $user->_id . '">
                <i class="bi bi-trash"></i>
                </button>
                </div>
                '
            ];
        }

        return response()->json([
            "draw" => $request->draw,
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalData,
            "data" => $data
        ]);
    }

    public function bulkDelete(Request $request)
    {

        User::whereIn('_id', $request->ids)->delete();

        return response()->json([
            'status' => true
        ]);
    }

    public function userDetail($id)
    {

        $user = User::find($id);

        return response()->json($user);
    }



    public function destroy($id)
    {

        User::where('_id', $id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted'
        ]);
    }

    public function exportUsers(Request $request)
    {
        $query = User::query();

        if ($request->search) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('admin.users.pdf', compact('users'));

        return $pdf->download('users-report.pdf');
    }
}
