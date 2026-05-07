<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏︎ 支出の編集
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                {{-- バリデーションエラー --}}
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('expenses.update', $expense) }}" method="post" class="space-y-4">
                    @csrf
                    @method('PUT')

                    @include('expenses._form',[
                        'expense'    => $expense,
                        'categories' => $categories,
                        'submit'     => '更新する',
                    ])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
