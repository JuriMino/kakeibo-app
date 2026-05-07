<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ExpenseController extends Controller
{

    // カテゴリの選択肢（フォーム共通で使うので定数化）
    private const CATEGORIES = ['食費', '交通費', '娯楽', '日用品', '通信費', '教育費', '被服費', 'その他'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 一覧表示
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $expenses = $user->expenses()->orderBy('spent_on', 'desc')->get();

        $total = $expenses->sum('amount');

        return view('expenses.index', compact('expenses', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 新規作成画面表示

        return view('expenses.create', ['categories' => self::CATEGORIES,]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'category' => 'required|in:' . implode(',', self::CATEGORIES),
            'spent_on' => 'required|date',
            'memo' => 'nullable|string',
        ]);

        // ログインユーザーに紐付けて作成
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->expenses()->create($validated);

        return redirect()->route('expenses.index')->with('success', '支出を登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 詳細画面は不要
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $this->authorizeOwner($expense);

        return view('expenses.edit', [
            'expense' => $expense,
            'categories' => self::CATEGORIES,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $this->authorizeOwner($expense);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'category' => 'required|in:' . implode(',', self::CATEGORIES),
            'spent_on' => 'required|date',
            'memo' => 'nullable|string',
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')->with('success', '支出を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $this->authorizeOwner($expense);

        $expense->delete();

        return redirect()->route('expenses.index')->with('success','支出を削除しました');
    }

    // 自分の支出かどうかをチェックする。他人のデータの場合403を返す
    public function authorizeOwner(Expense $expense): void
    {
        if($expense->user_id !== Auth::id()){
            throw new AccessDeniedHttpException('この支出にアクセスする権限がありません');
        }
    }
}
