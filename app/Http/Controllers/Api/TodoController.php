<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }
    public function index(Request $request)
    {
        try {
            $search = $request->get('search');
            $todos  = $this->todo->getUserTodos($search);

            return response()->json([
                'success' => true,
                'message' => 'Tasks retrieved successfully.',
                'data'    => $todos,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving tasks.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function store(TodoRequest $request)
    {
        try {
            $todo = $this->todo->createTodo($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Task added successfully.',
                'data'    => $todo,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create task.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function update(TodoRequest $request, $id)
    {
        try {
            $todo = $this->todo->updateUserTodo($id, $request->validated()['is_completed']);
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'data'    => $todo,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the status.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->todo->deleteUserTodo($id);
            return response()->json([
                'success' => true,
                'message' => 'Soft-deleted successfully.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting todo.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
