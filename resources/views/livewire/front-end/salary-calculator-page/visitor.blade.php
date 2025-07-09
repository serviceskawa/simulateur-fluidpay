<div class="mx-auto" style="max-width: 750px; margin: 50px auto;">
    <div class="row text-center">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 d-flex flex-column justify-content-center align-items-center" style="height: 150px;">
                <h6 class="fw-bold mb-1">Visiteurs</h6>
               <span style="font-size: 150%;">{{ $totalVisiteurs }}</span>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 d-flex flex-column justify-content-center align-items-center" style="height: 150px;">
                <h6 class="fw-bold mb-1">Calculs apd brut</h6>
                <span style="font-size: 150%;">{{ $totalBrut }}</span>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 d-flex flex-column justify-content-center align-items-center" style="height: 150px;">
                <h6 class="fw-bold mb-1">Calculs apd net</h6>
                <span style="font-size: 150%;">{{ $totalNet }}</span>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm p-3 d-flex flex-column justify-content-center align-items-center" style="height: 150px;">
                <h6 class="fw-bold mb-1">PDF générés</h6>
                <span style="font-size: 150%;">{{ $totalPdf }}</span>
            </div>
        </div>
    </div>
</div>
