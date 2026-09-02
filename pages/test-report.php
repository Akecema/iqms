<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed QA Reports | iQims</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --corp-green: #337A36;
            --corp-dark-green: #285A2A; /* For Hover */
            --slate-gray: #64748B;
            --light-gray: #F8FAFC;
        }

        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #EDF2F7; color: #2D3748; }

        /* Modern Main Header */
        .page-header { background-color: #FFFFFF; padding: 1.5rem 2rem; border-bottom: 1px solid #E2E8F0; margin-bottom: 2rem; }
        .page-title { font-size: 1.75rem; font-weight: bold; color: var(--corp-green); margin: 0; }
        .page-subtitle { color: var(--slate-gray); font-size: 10pt; }

        /* Report Cards */
        .report-card { background: #FFFFFF; border: none; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .report-card-header { background-color: var(--light-gray); padding: 1rem 1.25rem; border-bottom: 1px solid #E2E8F0; font-weight: bold; color: var(--corp-green); text-transform: uppercase; letter-spacing: 0.5px; font-size: 10pt; }
        .report-card-body { padding: 1.25rem; }

        /* Modern Search Input */
        .search-input { border-radius: 20px; padding-left: 2.5rem; border: 1px solid #D1DBE5; transition: border-color 0.15s; }
        .search-input:focus { border-color: var(--corp-green); box-shadow: 0 0 0 0.25rem rgba(51, 122, 54, 0.15); }
        .search-icon { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--slate-gray); }

        /* Corporate Table Styling */
        .corp-table { font-size: 9pt; vertical-align: middle; }
        .corp-table thead th { color: var(--slate-gray); font-weight: 600; text-transform: uppercase; font-size: 8pt; border-bottom: 2px solid #E2E8F0; }
        .corp-table tbody td { border-bottom: 1px solid #F1F5F9; color: #2D3748; }
        .corp-table tbody tr:hover { background-color: rgba(51, 122, 54, 0.03); }

        /* Main Data Point vs Sub Text */
        .main-data { font-weight: 600; color: #1A202C; }
        .sub-text { font-size: 8pt; color: var(--slate-gray); }

        /* Corporate View Button */
        .btn-view { background-color: var(--light-gray); color: var(--corp-green); border: 1px solid #D1DBE5; border-radius: 20px; font-size: 8pt; font-weight: 600; padding: 4px 12px; }
        .btn-view:hover { background-color: var(--corp-green); color: #FFFFFF; border-color: var(--corp-dark-green); }

        /* Results Colors */
        .res-ok { color: var(--corp-green); font-weight: 700; }
        .res-ng { color: #E74C3C; font-weight: 700; }

        /* Pagination Styling */
        .pagination .page-link { color: var(--corp-green); font-size: 9pt; }
        .pagination .page-item.active .page-link { background-color: var(--corp-green); border-color: var(--corp-green); color: #FFFFFF; }
    </style>
</head>
<body>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Completed Final Reports</h1>
        <span class="page-subtitle">Centralized access to finalized Inspection and Sorting records.</span>
    </div>
    <div class="d-flex gap-2">
        </div>
</div>

<div class="container-fluid px-4">
    <div class="row g-4">

        <div class="col-xl-6 col-lg-6 col-md-12">
            <div class="card report-card">
                <div class="card-header report-card-header d-flex justify-content-between align-items-center">
                    <span>A. Inspection Reports</span>
                    <span class="badge bg-success" style="font-size: 7pt; padding: 3px 6px;">COMPLETED (1,240)</span>
                </div>
                <div class="card-body report-card-body">
                    
                    <div class="row g-2 mb-3">
                        <div class="col-md-7 position-relative">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" class="form-control search-input" placeholder="Search by Doc No, Part No, or Date...">
                        </div>
                        <div class="col-md-5">
                            <select class="form-select form-control search-input">
                                <option>Filter by Result: All</option>
                                <option>Result: OK</option>
                                <option>Result: NG</option>
                            </select>
                        </div>
                    </div>

                    <table class="table corp-table table-hover">
                        <thead>
                            <tr>
                                <th width="15%">Doc No</th>
                                <th width="35%">Part & Model</th>
                                <th width="15%" class="text-center">Insp. Date</th>
                                <th width="15%" class="text-center">Shift</th>
                                <th width="10%" class="text-center">Result</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="main-data">IR24080101</span></td>
                                <td>
                                    <span class="main-data">13679-0K020</span><br>
                                    <span class="sub-text">BUMPER FR (MOD: TGN16, FR-RH)</span>
                                </td>
                                <td class="text-center">01 Aug 2024</td>
                                <td class="text-center sub-text">Shift A (Morning)</td>
                                <td class="text-center res-ok">OK</td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-view">VIEW</a>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="main-data">IR24072914</span></td>
                                <td>
                                    <span class="main-data">25841-3A010</span><br>
                                    <span class="sub-text">GRILLE RADIATOR (MOD: TGN26)</span>
                                </td>
                                <td class="text-center">29 Jul 2024</td>
                                <td class="text-center sub-text">Shift B (Night)</td>
                                <td class="text-center res-ng">NG</td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-view">VIEW</a>
                                </td>
                            </tr>
                            </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="sub-text">Showing 1 to 10 of 1,240 results</span>
                        <nav aria-label="Inspection pagination">
                            <ul class="pagination pagination-sm m-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-12">
            <div class="card report-card">
                <div class="card-header report-card-header d-flex justify-content-between align-items-center">
                    <span>B. Sorting Reports</span>
                    <span class="badge bg-success" style="font-size: 7pt; padding: 3px 6px;">COMPLETED (518)</span>
                </div>
                <div class="card-body report-card-body">
                    
                    <div class="row g-2 mb-3">
                        <div class="col-md-7 position-relative">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" class="form-control search-input" placeholder="Search by Doc No, Vendor, or Date...">
                        </div>
                        <div class="col-md-5">
                            <select class="form-select form-control search-input">
                                <option>Filter by Source: All</option>
                                <option>In-House</option>
                                <option>Vendor</option>
                                <option>Customer</option>
                            </select>
                        </div>
                    </div>

                    <table class="table corp-table table-hover">
                        <thead>
                            <tr>
                                <th width="15%">Doc No</th>
                                <th width="30%">Related Party</th>
                                <th width="15%" class="text-center">Date</th>
                                <th width="15%" class="text-center qty-ok">Qty OK</th>
                                <th width="15%" class="text-center qty-ng">Qty NG</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="main-data">SR24080112</span></td>
                                <td>
                                    <span class="main-data">DENSO Malaysia</span><br>
                                    <span class="sub-text">Related Party (Vendor)</span>
                                </td>
                                <td class="text-center">01 Aug 2024</td>
                                <td class="text-center qty-ok">2,500</td>
                                <td class="text-center qty-ng">4</td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-view">VIEW</a>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="main-data">SR24072809</span></td>
                                <td>
                                    <span class="main-data">Injection Molding</span><br>
                                    <span class="sub-text">Related Dept (In-House)</span>
                                </td>
                                <td class="text-center">28 Jul 2024</td>
                                <td class="text-center qty-ok">98</td>
                                <td class="text-center qty-ng">7</td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-view">VIEW</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="sub-text">Showing 1 to 10 of 518 results</span>
                        <nav aria-label="Sorting pagination">
                            <ul class="pagination pagination-sm m-0">
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.min.js"></script>
</body>
</html>