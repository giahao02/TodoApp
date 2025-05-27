<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'is_completed',
        'user_id',
    ];

    public function getUserTodos(?string $search = null)
    {
        $query = self::query()->where('user_id', auth()->id());
        if (! empty($search)) {
            $query->where('description', 'like', '%' . $search . '%');
        }
        return $query->get();
    }

    public function createTodo(array $data)
    {
        return auth()->user()->todos()->create([
            'description'  => $data['description'],
            'is_completed' => false,
        ]);
    }

    public function updateUserTodo(int $id, bool $is_completed)
    {
        $todo = self::where('user_id', auth()->id())->findOrFail($id);
        $todo->update(['is_completed' => $is_completed]);
        return $todo;
    }

    public function deleteUserTodo(int $id)
    {
        $todo = self::where('user_id', auth()->id())->findOrFail($id);
        $todo->delete();
        return true;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
