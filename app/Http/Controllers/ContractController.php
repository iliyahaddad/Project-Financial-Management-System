<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Project;
use App\Services\ContractService;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;

class ContractController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('view', $project);
        $contracts = $project->contracts;
        return view('contracts.index', compact('project', 'contracts'));
    }

    public function store(StoreContractRequest $request, Project $project, ContractService $service)
    {
        $this->authorize('create', Contract::class);
        $contract = $service->create($project, $request->validated());
        return redirect()->route('projects.contracts.show', [$project, $contract])->with('message', 'قرارداد با موفقیت ایجاد شد');
    }

    public function show(Project $project, Contract $contract)
    {
        $this->authorize('view', $contract);
        return view('contracts.show', compact('project', 'contract'));
    }

    public function update(UpdateContractRequest $request, Project $project, Contract $contract, ContractService $service)
    {
        $this->authorize('update', $contract);
        $service->update($contract, $request->validated());
        return redirect()->route('projects.contracts.show', [$project, $contract])->with('message', 'قرارداد به‌روزرسانی شد');
    }
}
