@extends('layouts.teacher')

@section('title', 'Subcategory List — TeacherHub OBE')
@section('page_title', 'Subcategory List')

@section('content')
<div class="p-hero">
    <div><div class="p-hero-h">Subcategory (Course) List</div><div class="p-hero-sub">Subcategories mapped to major categories and course codes</div></div>
</div>

<div class="d-card" style="animation-delay:.05s">
    <div class="d-card-header">
        <div class="d-card-title"><div class="d-card-ico"><i class="fas fa-layer-group"></i></div>Subcategories Under Major Categories</div>
        <span class="badge b-green" style="padding:5px 12px;">{{ str_pad($subcategories->total(), 2, '0', STR_PAD_LEFT) }} records</span>
    </div>
    <div class="d-card-body p0">
        <div class="t-wrap">
            <table class="t-tbl">
                <thead>
                    <tr>
                        <th style="text-align:center; width: 60px;">#</th>
                        <th style="text-align:center;">Subcategory Name</th>
                        <th style="text-align:center;">Courses</th>
                        <th style="text-align:center;">Status</th>
                    </tr>
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
                    @forelse($subcategories as $index => $subcategory)
                        @php $style = $colors[$index % count($colors)]; @endphp
                        <tr>
                            <td style="text-align:center;"><span class="t-num">{{ str_pad($subcategories->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</span></td>
                            <td style="text-align:center;">
                                <div style="display:flex;align-items:center;justify-content:center;gap:9px;">
                                    <div style="width:7px;height:7px;border-radius:50%;background:{{ $style['text'] }};box-shadow:0 0 0 2px {{ $style['bg'] }};flex-shrink:0;"></div>
                                    <span class="t-name" style="width:95px;text-align:left;word-break:break-word;line-height:1.3;">{{ $subcategory->name }}</span>
                                </div>
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex;align-items:center;justify-content:center;gap:7px;">
                                    <div class="cat-ico" style="width:24px;height:24px;background:var(--info-lt, #e0f2fe);color:var(--info, #0ea5e9);font-size:.60rem;"><i class="fas fa-book"></i></div>
                                    <span class="badge b-blue" style="font-weight: 600;">{{ str_pad($subcategory->courses->count(), 2, '0', STR_PAD_LEFT) }} Courses</span>
                                </div>
                            </td>
                            <td style="text-align:center;">
                                @if($subcategory->is_active)
                                    <span class="badge b-green"><i class="fas fa-check" style="margin-right:4px;"></i>Active</span>
                                @else
                                    <span class="badge b-gray" style="color:var(--tx-m);"><i class="fas fa-ban" style="margin-right:4px;"></i>Inactive</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state" style="padding: 60px 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                                    <div class="empty-ico" style="font-size: 3.5rem; color: var(--bd); margin-bottom: 20px;"><i class="fas fa-layer-group"></i></div>
                                    <h5 style="color: var(--tx-h); font-weight: 700; margin-bottom: 8px; font-size: 1.1rem;">No Subcategories Available</h5>
                                    <p style="color: var(--tx-m); font-size: 0.9rem; max-width: 450px; margin: 0 auto; line-height: 1.5;">There are currently no subcategories assigned or available in the system.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($subcategories->hasPages())
<div style="padding: 15px 20px; display:flex; justify-content:flex-end;">
    {{ $subcategories->links('pagination::bootstrap-5') }}
</div>
@endif
@endsection
