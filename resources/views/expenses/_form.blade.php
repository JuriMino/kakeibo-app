<div>
    <label for="title" class="block text-sm font-medium text-gray-700">項目名（必須）</label>
    <input type="text" name="title" id="title" value="{{ old('title', $expense?->title) }}"
        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
</div>

<div class="grid grif-cols-2 gap-4">
    <div>
        <label for="amount" class="block text-sm font-medium text-gray-700">金額（円）</label>
        <input type="number" name="amount" id="amount" min="1"
            value="{{ old('amount', $expense?->amount) }}"
            class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
    </div>
    <div>
        <label for="amount" class="block text-sm font-medium text-gray-700">支出日</label>
        <input type="date" name="spent_on" id="spent_on" min="1"
            value="{{ old('spent_on', $expense?->spent_on?->format('Y-m-d')) ?? now()->format('Y-m-d') }}"
            class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
    </div>
</div>

<div>
    <label for="category" class="block text-sm font-medium text-gray-700">カテゴリー</label>
    <select name="category" id="category"
        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
        @foreach ($categories as $cat)
            <option value="{{ $cat }}" {{ old('category', $expense?->category) === $cat ? 'selected' : '' }}>
                {{ $cat }}
            </option>
        @endforeach
    </select>
</div>
<div>
    <label for="memo" class="block text-sm font-medium text-gray-700">メモ（任意）</label>
    <textarea name="memo" id="memo" rows="3" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('memo', $expense?->memo) }}</textarea>
</div>

<div class="flex items-center justify-end space-x-3 pt-4">
    <a href="{{ route('expenses.index') }}" class="text-sm text-gray-600 hover:underline mr-4">キャンセル</a>
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-md shadow">
        {{ $submit }}
    </button>
</div>
