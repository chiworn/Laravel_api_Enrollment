<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = DB::table('tb_students')->get();
        return response()->json([
            'status' => 202,
            'message'=>'success',
            'Data'  => $students,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $val = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email_stu'  => 'required|email|unique:tb_students,email_stu',
            'phone_num'  => 'required|string|max:100',
            'gender'     => 'required|string',
        ]);
        DB::table('tb_students')->insert([
            'frist_name' => $val['first_name'],
            'last_name'  => $val['last_name'],
            'email_stu'  => $val['email_stu'],
            'phone_num'  => $val['phone_num'],
            'creat_at'   => now()
        ]);

        $students = DB::table('tb_students')->get();
        return response()->json([
            'status'         =>  202,
            'message'        => 'insert succes',
            'Data_students'  =>  $students,
        ]);
    }

    public function show(string $id)
    {
        $student = DB::table('tb_students')->where('id',$id)->first();
        if(!$student){
            return response()->json([
                'status' => 404,
                'message' => 'students not foun',
            ]);
        }
         return response()->json([
                'message' => 'Sreach successfully',
                'Student' => $student,
            ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, string $id)
    {

         $val = $req->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email_stu'  => 'required|email|unique:tb_students,email_stu',
            'phone_num'  => 'required|string|max:100',
            'gender'     => 'required|string',
        ]);
        DB::table('tb_students')->where('id',$id)->update([
            'frist_name' => $val['first_name'],
            'last_name'  => $val['last_name'],
            'email_stu'  => $val['email_stu'],
            'phone_num'  => $val['phone_num'],
            'creat_at'   => now()
        ]);
        $update = DB::table('tb_students')->where('id',$id)->first();
        return response()->json([
            'status:'    => 202,
            'Message Success:' => 'Update student success',
            'Studnets update:' => $update,
        ]);

    }
    public function destroy(string $id)
    {
       $del = DB::table('tb_students')->where('id',$id)->delete();
        if(!$del){
             return response()->json(['message' => 'Student not found'], 404);
        }
        return response()->json([
            'Message'   => 'Delete Success',
        ],202);
    }
}
