@extends('layouts.app')

@section('title', 'History')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>History</h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>All History</h4>
                    </div>
                    <div class="card-body">
                        <div class="float-right">
                            <form action="{{ route('history.index') }}" method="GET" class="form-inline pull-right">
                                {{-- <div class="form-group">
                                            <input type="date" class="form-control" name="start_date"
                                                value="{{ request('start_date') }}">
                                            <input type="date" class="form-control" name="end_date"
                                                value="{{ request('end_date') }}">
                                        </div> --}}
                                <!-- Month Selector -->
                                <div class="form-group mr-2">
                                    <select class="form-control" name="month">
                                        <option value="">Select Month</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}"
                                                {{ request('month') == $i ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <!-- Year Selector -->
                                <div class="form-group mr-2">
                                    <select class="form-control" name="year">
                                        <option value="">Select Year</option>
                                        @for ($year = date('Y'); $year >= date('Y') - 10; $year--)
                                            <option value="{{ $year }}"
                                                {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">
                                    Filter
                                </button>
                                <a href="{{ route('exportPDF.historyAll', [
                                    'start_date' => request('start_date'),
                                    'end_date' => request('end_date'),
                                    'month' => request('month'),
                                    'year' => request('year'),
                                ]) }}"
                                    class="btn btn-danger">Export PDF</a>
                            </form>
                        </div>
                        <div class="clearfix mb-3"></div>

                        <div class="table-responsive">
                            <table class="table-striped table">
                                <tr>
                                    <th>Transaction Time</th>
                                    <th>Total Price</th>
                                    <th>Kasir</th>
                                    <th>Metode Pembayaran</th>
                                </tr>
                                @foreach ($transactions as $item)
                                    <tr>
                                        <td>
                                            <a href="{{ route('history.show', $item->id) }}">
                                                {{ $item->transaction_date }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $item->total_price }}
                                        </td>
                                        <td>
                                            {{ $item->kasir->name }}
                                        </td>
                                        <td>
                                            {{ $item->payment_method }}
                                        </td>
                                    </tr>
                                @endforeach


                            </table>
                        </div>
                        {{-- <div class="float-right">
                                    {{ $transactions->withQueryString()->links() }}
                                </div> --}}
                        <div class="float-right">
                            {{ $transactions->appends(['start_date' => request('start_date'), 'end_date' => request('end_date')])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const setDateRange = (start, end) => {
                document.querySelector('input[name="start_date"]').value = start;
                document.querySelector('input[name="end_date"]').value = end;
            };

            document.getElementById('today').addEventListener('click', () => {
                const today = new Date().toISOString().split('T')[0];
                setDateRange(today, today);
            });

            // Add more event listeners for other buttons as needed
        });
    </script>
@endpush
