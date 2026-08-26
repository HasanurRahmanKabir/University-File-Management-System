@extends('layouts.teacher')

@section('title', 'Category List — TeacherHub OBE')
@section('page_title', 'Category List')

@section('content')
<div class="p-hero">
    <div><div class="p-hero-h">Course Categories</div><div class="p-hero-sub">Browse and view major course categories</div></div>
</div>

<div class="d-card" style="animation-delay:.05s">
    <div class="d-card-header">
        <div class="d-card-title"><div class="d-card-ico"><i class="fas fa-tags"></i></div>Major Categories</div>
        <span class="badge b-green" style="padding:5px 12px;">{{ str_pad($categories->total(), 2, '0', STR_PAD_LEFT) }} categories</span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl">
                <thead>
                    <tr><th style="text-align:center; width: 60px;">#</th><th style="text-align:center;">Category Name</th><th style="text-align:center;">Courses</th><th style="text-align:center;">Description</th></tr>
                </thead>
                <tbody>
                    @php
                        $colors = [
                            ['bg' => 'var(--success-lt)', 'text' => 'var(--success)', 'icon' => 'fa-code-branch'],
                            ['bg' => 'var(--purple-lt)', 'text' => 'var(--purple)', 'icon' => 'fa-sitemap'],
                            ['bg' => 'var(--info-lt)', 'text' => 'var(--info)', 'icon' => 'fa-layer-group'],
                            ['bg' => 'var(--warning-lt)', 'text' => 'var(--warning)', 'icon' => 'fa-hashtag'],
                        ];
                    @endphp
                    @forelse($categories as $index => $category)
                        @php $style = $colors[$index % count($colors)]; @endphp
                        <tr>
                            <td style="text-align:center;"><span class="t-num">{{ str_pad($categories->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</span></td>
                            <td style="text-align:center;">
                                <div style="display:flex;align-items:center;justify-content:center;gap:10px;">
                                    <div class="cat-ico" style="width:34px;height:34px;background:{{ $style['bg'] }};color:{{ $style['text'] }};flex-shrink:0;">
                                        <i class="fas {{ $style['icon'] }}" style="font-size:.76rem;"></i>
                                    </div>
                                    <span class="t-name" style="width:160px;text-align:left;word-break:break-word;line-height:1.3;">{{ $category->name }}</span>
                                </div>
                            </td>
                            <td style="text-align:center;"><span class="badge b-blue">{{ str_pad($category->courses_count, 2, '0', STR_PAD_LEFT) }} Courses</span></td>
                            <td style="text-align:center; color:var(--tx-s); font-size:.80rem;">{{ $category->description ?? 'No description available.' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state" style="padding: 60px 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                                    <div class="empty-ico" style="font-size: 3.5rem; color: var(--bd); margin-bottom: 20px;"><i class="fas fa-tags"></i></div>
                                    <h5 style="color: var(--tx-h); font-weight: 700; margin-bottom: 8px; font-size: 1.1rem;">No Categories Available</h5>
                                    <p style="color: var(--tx-m); font-size: 0.9rem; max-width: 450px; margin: 0 auto; line-height: 1.5;">There are currently no course categories assigned or available in the system.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($categories->hasPages())
<div style="padding: 15px 20px; display:flex; justify-content:flex-end;">
    {{ $categories->links('pagination::bootstrap-5') }}
</div>
@endif

@endsection
