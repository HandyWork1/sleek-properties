@props([
  'columns'     => [],
  'rows'        => [],
  'searchable'  => false,
  'filters'     => [],
  'pagination'  => null,
])

<div class="my-4 space-y-4 w-full">
  {{-- Filters --}}
  @isset($extraFilters)
    <div>{{ $extraFilters }}</div>
  @elseif($searchable || count($filters))
    <form method="GET" class="flex flex-col sm:flex-row gap-2">
      @if($searchable)
        <input name="search" value="{{ request('search') }}" placeholder="Search…"
               class="flex-1 px-3 py-2 border rounded-md text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
      @endif

      @foreach($filters as $f)
        <select name="{{ $f['name'] }}"
                class="px-3 py-2 border rounded-md text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
          <option value="">{{ $f['label'] }}</option>
          @foreach($f['options'] as $val => $lab)
            <option value="{{ $val }}" @selected(request($f['name']) == $val)>{{ $lab }}</option>
          @endforeach
        </select>
      @endforeach
    </form>
  @endif

  {{-- Table --}}
  <div class="relative overflow-x-auto shadow-sm rounded-lg">
    <table class="min-w-full my-6 text-sm text-left text-gray-600 dark:text-gray-300">
      <thead class="bg-gray-100 dark:bg-gray-700 text-xs uppercase text-gray-700 dark:text-gray-200">
        <tr>
          @foreach($columns as $col)
            <th class="px-4 py-3">{{ $col['label'] }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
        @forelse($rows as $row)
          <tr @class([
              'odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700',
              'hover:bg-gray-100 dark:hover:bg-gray-600 transition'
            ])>
            @foreach($columns as $col)
              <td class="px-4 py-2 whitespace-nowrap align-top">
                @if(isset($col['component']))
                  {{-- Renders component for the actions column --}}
                  <x-dynamic-component :component="$col['component']" :row="$row" />
                @elseif(!empty($col['formatter']))
                  @if(is_callable($col['formatter']))
                    {!! $col['formatter']($row) !!}
                  @else
                    @includeIf('components.table.cells.'.$col['formatter'], ['row'=>$row,'col'=>$col])
                  @endif
                @else
                  {{ data_get($row, $col['key']) }}
                @endif
              </td>
            @endforeach

          </tr>
        @empty
          <tr>
            <td colspan="{{ count($columns) }}"
                class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
              No records found.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if($pagination)
    <div class="mt-2">
      {{ $pagination->withQueryString()->links('vendor.pagination.tailwind') }}
    </div>
  @endif
</div>
