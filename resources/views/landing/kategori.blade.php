@extends('layouts.user.main')

@section('content')
<br><br><br><br><br><br>
<div class="container py-5">

    <h3 class="mb-4">
        Kategori: {{ $category->name }}
    </h3>

    @if($jobs->count() === 0)
        <div class="alert alert-warning">
            Belum ada jasa pada kategori ini.
        </div>
    @else
        <div class="row g-4">
            @foreach($jobs as $job)
            @php
                $rating = round($job->avg_rating ?? 0, 1);
                $fullStar = floor($rating);
                $halfStar = ($rating - $fullStar) >= 0.5;
                $emptyStar = 5 - $fullStar - ($halfStar ? 1 : 0);
            @endphp

            <!--
            col-6   → mobile = 2 kolom
            col-md-4 → tablet = 3 kolom
            col-lg-3 → desktop = 4 kolom
            -->
            <div class="col-6 col-md-4 col-lg-3">
                <div style="border-radius: 15px;"
                    class="position-relative fruite-item border h-100 d-flex flex-column">

                    <div class="fruite-img" style="height: 200px; overflow: hidden;">
                        <a href="{{ route('job.show', $job->id) }}">
                            @if($job->job_image)
                                <img src="{{ asset('storage/' . $job->job_image) }}"
                                    class="img-fluid w-100 rounded-top"
                                    alt="{{ $job->title }}"
                                    style="height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ asset('assets/user/img/fruite-item-5.jpg') }}"
                                    class="img-fluid w-100 rounded-top"
                                    alt="default"
                                    style="height: 100%; object-fit: cover;">
                            @endif
                        </a>
                    </div>

                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                        style="top: 10px; left: 10px;">
                        {{ $job->category->name }}
                    </div>

                    <div class="p-4 border-top-0 rounded-bottom d-flex flex-column flex-grow-1 text-start">
                        <h5>{{ Str::limit($job->title, 35) }}</h5>
                        <p class="small">{{ Str::limit($job->description, 50) }}</p>

                        {{-- Rating --}}
                        <div class="mb-3 d-flex align-items-center gap-1">
                            @for($i = 1; $i <= $fullStar; $i++)
                                <i class="fas fa-star text-warning"></i>
                            @endfor

                            @if($halfStar)
                                <i class="fas fa-star-half-alt text-warning"></i>
                            @endif

                            @for($i = 1; $i <= $emptyStar; $i++)
                                <i class="far fa-star text-warning"></i>
                            @endfor

                            <small class="text-muted ms-1">
                                {{ number_format($rating, 1) }}
                            </small>
                        </div>

                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <p class="text-dark fw-bold mb-0 small">
                                <i class="bi bi-geo-alt-fill"></i>
                                {{ Str::limit($job->location, 13) }}
                            </p>

                            <a href="{{ route('job.show', $job->id) }}"
                            class="btn btn-sm border border-primary rounded-pill px-3 text-primary">
                                Order
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
        </div>
    @endif

</div>
@endsection
