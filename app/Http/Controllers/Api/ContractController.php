<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Project;
use App\Services\ContractService;
use App\Http\Requests\StoreContractRequest;

class ContractController extends Controller
{
    public function index(Project $project)
    {
        $contracts = $project->contracts;
        return response()->json($contracts);
    }

    public function show(Project $project, Contract $contract)
    {
        return response()->json($contract);
    }

    public function store(StoreContractRequest $request, Project $project, ContractService $service)
    {
        $contract = $service->create($project, $request->validated());
        return response()->json($contract, 201);
    }
}
