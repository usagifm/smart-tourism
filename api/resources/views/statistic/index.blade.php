@extends('layouts.app')

@section('title')
    Statistik - Smart Tourism
@endsection

@section('custom_styles')
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Analisis</h1>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <h6 class="font-weight-bold text-danger">Grafik Keuangan</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <form action="{{ route('statistic.rent') }}" method="GET" class="col-3"
                                id="formFilter">
                                <div class="form-group">
                                    <select name="filter" class="form-control">
                                        <option value="month"
                                            {{ request()->query('filter') == 'month' ? 'selected' : '' }}>
                                            Bulan Ini</option>
                                        <option value="year" {{ request()->query('filter') == 'year' ? 'selected' : '' }}>
                                            Tahun Ini
                                        </option>
                                    </select>
                                </div>
                            </form>
                            <button class="btn btn-danger h-75" type="submit" form="formFilter">Filter</button>
                            <button class="btn btn-outline-danger h-75 ml-5" id="download"
                                onclick="generatePDF()">Download</button>
                        </div>
                        <div class="html-content">
                            {!! $chart->renderHtml() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@section('custom_scripts')
    {!! $chart->renderChartJsLibrary() !!}
    {!! $chart->renderJs() !!}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script type="text/javascript">
        function generatePDF() {
            var HTML_Width = $(".html-content").width();
            var HTML_Height = $(".html-content").height();
            var top_left_margin = 15;
            var PDF_Width = HTML_Width + (top_left_margin * 2);
            var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
            var canvas_image_width = HTML_Width;
            var canvas_image_height = HTML_Height;

            var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

            html2canvas($(".html-content")[0]).then(function(canvas) {
                var imgData = canvas.toDataURL("image/jpeg", 1.0);
                var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
                pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width,
                    canvas_image_height);
                for (var i = 1; i <= totalPDFPages; i++) {
                    pdf.addPage(PDF_Width, PDF_Height);
                    pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height * i) + (top_left_margin * 4),
                        canvas_image_width, canvas_image_height);
                }
                pdf.save("Statistik Penyewaan.pdf");
                // $(".html-content").hide();
            });
        }
    </script>
@endsection
