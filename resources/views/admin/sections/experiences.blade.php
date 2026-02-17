<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-building"></i> Manage Experiences</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExperienceModal">
        <i class="fas fa-plus"></i> Add Experience
    </button>
</div> 

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th width="5%">#</th>
                <th width="20%">Position</th>
                <th width="20%">Company</th>
                <th width="15%">Period</th>
                <th width="10%">Status</th>
                <th width="10%">Order</th>
                <th width="20%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($experiences as $index => $exp)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $exp->position }}</strong></td>
                <td>{{ $exp->company }}</td>
                <td>
                    {{ $exp->start_date->format('M Y') }}
                    @if($exp->is_current)
                        - <span class="badge bg-success">Present</span>
                    @else
                        - {{ $exp->end_date ? $exp->end_date->format('M Y') : '-' }}
                    @endif
                </td>
                <td>
                    @if($exp->is_current)
                        <span class="badge bg-success">Current</span>
                    @else
                        <span class="badge bg-secondary">Past</span>
                    @endif
                </td>
                <td>{{ $exp->display_order }}</td>
                <td>
                    <button class="btn btn-sm btn-info mb-1" 
                            onclick="viewAchievements({{ json_encode($exp->achievements) }})"
                            data-bs-toggle="modal" 
                            data-bs-target="#viewAchievementsModal">
                        <i class="fas fa-list"></i> Achievements
                    </button>
                    <button class="btn btn-sm btn-warning mb-1" 
                            onclick="editExperience({{ json_encode($exp) }})"
                            data-bs-toggle="modal" 
                            data-bs-target="#editExperienceModal">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.experiences.destroy', $exp->id) }}" 
                          method="POST" 
                          style="display: inline-block;"
                          onsubmit="return confirm('Delete this experience?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted">
                    <i class="fas fa-building fa-3x mb-3 d-block"></i>
                    No experiences found. Add your first experience!
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Add Experience -->
<div class="modal fade" id="addExperienceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Add New Experience</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.experiences.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Position <span class="text-danger">*</span></label>
                                <input type="text" name="position" class="form-control" placeholder="e.g., Senior Developer" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Company <span class="text-danger">*</span></label>
                                <input type="text" name="company" class="form-control" placeholder="e.g., Tech Company" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" id="add_end_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_current" value="1" class="form-check-input" id="add_is_current" onchange="toggleEndDate(this, 'add_end_date')">
                            <label class="form-check-label" for="add_is_current">
                                <i class="fas fa-check-circle text-success"></i> Currently working here
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Job description"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Achievements</label>
                        <div id="add_achievements_container">
                            <div class="input-group mb-2">
                                <input type="text" name="achievements[]" class="form-control" placeholder="Achievement 1">
                                <button type="button" class="btn btn-success" onclick="addAchievementField('add_achievements_container')">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <small class="text-muted">Add your key achievements in this role</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control" value="0" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Experience</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Experience -->
<div class="modal fade" id="editExperienceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Experience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editExperienceForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Position <span class="text-danger">*</span></label>
                                <input type="text" name="position" id="edit_position" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Company <span class="text-danger">*</span></label>
                                <input type="text" name="company" id="edit_company" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" id="edit_start_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" id="edit_end_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_current" value="1" class="form-check-input" id="edit_is_current" onchange="toggleEndDate(this, 'edit_end_date')">
                            <label class="form-check-label" for="edit_is_current">
                                <i class="fas fa-check-circle text-success"></i> Currently working here
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Achievements</label>
                        <div id="edit_achievements_container"></div>
                        <button type="button" class="btn btn-sm btn-success mt-2" onclick="addAchievementField('edit_achievements_container')">
                            <i class="fas fa-plus"></i> Add Achievement
                        </button>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" id="edit_display_order" class="form-control" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Update Experience</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal View Achievements -->
<div class="modal fade" id="viewAchievementsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-list"></i> Achievements</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul id="achievements_list" class="list-group"></ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Initialize on modal open
document.getElementById('addExperienceModal')?.addEventListener('show.bs.modal', function () {
    const addForm = document.querySelector('#addExperienceModal form');
    if (addForm) {
        addForm.reset();
        const container = document.getElementById('add_achievements_container');
        container.innerHTML = '<div class="input-group mb-2"><input type="text" name="achievements[]" class="form-control" placeholder="Achievement 1"><button type="button" class="btn btn-success" onclick="addAchievementField(\'add_achievements_container\')"><i class="fas fa-plus"></i></button></div>';
    }
});

function toggleEndDate(checkbox, endDateId) {
    const endDateInput = document.getElementById(endDateId);
    if (checkbox.checked) {
        endDateInput.value = '';
        endDateInput.disabled = true;
        endDateInput.required = false;
    } else {
        endDateInput.disabled = false;
    }
}

function addAchievementField(containerId) {
    const container = document.getElementById(containerId);
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" name="achievements[]" class="form-control" placeholder="Achievement">
        <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(div);
}

function editExperience(exp) {
    // Properly format date values (remove time component if present)
    let startDate = exp.start_date ? exp.start_date.split('T')[0] : '';
    let endDate = exp.end_date ? exp.end_date.split('T')[0] : '';
    
    document.getElementById('editExperienceForm').action = `/admin/experiences/${exp.id}`;
    
    document.getElementById('edit_position').value = exp.position || '';
    document.getElementById('edit_company').value = exp.company || '';
    document.getElementById('edit_start_date').value = startDate;
    document.getElementById('edit_end_date').value = endDate;
    document.getElementById('edit_description').value = exp.description || '';
    document.getElementById('edit_display_order').value = exp.display_order || 0;
    document.getElementById('edit_is_current').checked = exp.is_current || false;
    
    toggleEndDate(document.getElementById('edit_is_current'), 'edit_end_date');
    
    // Handle achievements
    const container = document.getElementById('edit_achievements_container');
    container.innerHTML = '';
    if (exp.achievements && exp.achievements.length > 0) {
        exp.achievements.forEach(achievement => {
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `
                <input type="text" name="achievements[]" class="form-control" value="${achievement}">
                <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(div);
        });
    } else {
        addAchievementField('edit_achievements_container');
    }
}

function viewAchievements(achievements) {
    const list = document.getElementById('achievements_list');
    list.innerHTML = '';
    
    if (achievements && achievements.length > 0) {
        achievements.forEach(achievement => {
            const li = document.createElement('li');
            li.className = 'list-group-item';
            li.innerHTML = `<i class="fas fa-check-circle text-success me-2"></i> ${achievement}`;
            list.appendChild(li);
        });
    } else {
        list.innerHTML = '<li class="list-group-item text-muted">No achievements added</li>';
    }
}
</script>
@endpush