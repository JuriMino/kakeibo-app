<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            💰家計簿一覧
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- フラッシュメッセージ --}}
            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded">
                    {{ session('success')}}
                </div>
            @endif

            {{-- 合計 + 新規追加ボタン --}}
            <div class="bg-white shadow rounded-lg p-6 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">合計支出額</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ number_format($total) }}</p>
                </div>
                <a href="{{ route('expenses.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-md shadow">
                    + 新規追加
                </a>
            </div>

            {{-- 支出一覧 --}}
            <div class="bg-white shadow rounded-lg overflow-hidden">
                @if ($expenses->isEmpty())
                    <p class="p-6 text-gray-500">まだ支出が登録されていません。</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">日付</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">項目</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">カテゴリ</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">金額</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">操作</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($expenses as $expense)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $expense->spent_on->format('Y/m/d') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $expense->title }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="inline-block px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-xs">
                                            {{ $expense->category}}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-left font-mono">¥ {{ number_format($expense->amount) }}</td>
                                    <td class="px-4 py-3 text-sm text-left space-x-2">
                                        <a href="{{ route('expenses.edit', $expense) }}" class="text-blue-600 hover:underline">編集</a>
                                        <form action="{{ route('expenses.destroy', $expense) }}" method="post" class="inline"  onsubmit="return confirm('本当に削除しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">削除</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
