@php $checklistIndex = $checklistStartIndex ?? 1; @endphp
@foreach($checklistGroups as $group)
<section class="rounded-2xl border border-app-line bg-white shadow-sm">
  <div class="border-b border-app-line px-5 py-4">
    <h2 class="section-title text-base font-extrabold text-app-ink">{{ $group['title'] }}</h2>
  </div>
  <div class="grid {{ $checklistGrid ?? 'grid-cols-2 gap-3 p-4' }}">
    @foreach($group['items'] as $item)
    <label class="check-item flex cursor-pointer items-start gap-3 rounded-xl border border-app-line bg-white p-3.5 transition-all hover:border-app-accent lg:hover:shadow-sm">
      <input type="checkbox" class="sr-only" data-check-id="{{ $checklistIndex }}">
      <span class="check-box mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border-2 border-stone-300 bg-white transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-4 w-4 text-app-accent opacity-0 transition-opacity"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
      </span>
      <span class="check-label text-sm font-semibold leading-6 text-app-ink transition-colors">{{ $item }}</span>
    </label>
    @php $checklistIndex++ @endphp
    @endforeach
  </div>
</section>
@endforeach
