<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'phone',
        'national_id',
        'avatar',
        'status',
        'last_login_at',
        'password',
        'email_verified_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roleName(): ?string
    {
        return $this->role?->name;
    }

    public function hasRole(string|array $roles): bool
    {
        return in_array($this->roleName(), (array) $roles, true);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function managedProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'project_manager_id');
    }

    public function managedWbs(): HasMany
    {
        return $this->hasMany(Wbs::class, 'responsible_person_id');
    }

    public function managedActivities(): HasMany
    {
        return $this->hasMany(Activity::class, 'responsible_person_id');
    }

    public function recordedProgresses(): HasMany
    {
        return $this->hasMany(ProjectProgress::class, 'recorded_by');
    }

    public function recordedManDays(): HasMany
    {
        return $this->hasMany(ProjectManDay::class, 'recorded_by');
    }

    public function createdCosts(): HasMany
    {
        return $this->hasMany(ProjectCost::class, 'created_by');
    }

    public function managedContracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'project_manager_id');
    }

    public function receivedCollections(): HasMany
    {
        return $this->hasMany(Collection::class, 'received_by');
    }

    public function forecastOverrides(): HasMany
    {
        return $this->hasMany(Forecast::class, 'override_by');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    public function uploadedDocuments(): HasMany
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    public function acknowledgedAlerts(): HasMany
    {
        return $this->hasMany(Alert::class, 'acknowledged_by');
    }

    public function resolvedAlerts(): HasMany
    {
        return $this->hasMany(Alert::class, 'resolved_by');
    }

    public function directCosts(): HasMany
    {
        return $this->hasMany(ProjectCost::class, 'employee_id');
    }

    public function approvedAmendments(): HasMany
    {
        return $this->hasMany(ContractAmendment::class, 'approved_by');
    }

    public function approvedInvoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'approved_by');
    }
}
