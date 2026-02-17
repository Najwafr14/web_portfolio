<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-code"></i> Manage Skills</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSkillModal">
        <i class="fas fa-plus"></i> Add Skill
    </button>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th width="5%">#</th>
                <th width="20%">Name</th>
                <th width="15%">Category</th>
                <th width="15%">Percentage</th>
                <th width="10%">Icon</th>
                <th width="10%">Order</th>
                <th width="15%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($skills as $index => $skill)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    @if($skill->icon)
                    <i class="{{ $skill->icon }} me-2"></i>
                    @endif
                    {{ $skill->name }}
                </td>
                <td><span class="badge bg-info">{{ $skill->category }}</span></td>
                <td>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-success" 
                             role="progressbar" 
                             style="width: {{ $skill->percentage }}%"
                             aria-valuenow="{{ $skill->percentage }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                            {{ $skill->percentage }}%
                        </div>
                    </div>
                </td>
                <td>
                    @if($skill->icon)
                    <code>{{ $skill->icon }}</code>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
                <td>{{ $skill->display_order }}</td>
                <td>
                    <button class="btn btn-sm btn-warning" 
                            onclick="editSkill({{ $skill->id }}, '{{ $skill->name }}', '{{ $skill->category }}', {{ $skill->percentage }}, '{{ $skill->icon }}', '{{ $skill->description }}', {{ $skill->display_order }})"
                            data-bs-toggle="modal" 
                            data-bs-target="#editSkillModal">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.skills.destroy', $skill->id) }}" 
                          method="POST" 
                          style="display: inline-block;"
                          onsubmit="return confirm('Are you sure want to delete this skill?')">
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
                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                    No skills found. Add your first skill!
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Add Skill -->
<div class="modal fade" id="addSkillModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Add New Skill</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.skills.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Skill Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g., Laravel" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-control" required>
                            <option value="">-- Select Category --</option>
                            <option value="Programming">Programming</option>
                            <option value="Database">Database</option>
                            <option value="Technology">Technology</option>
                            <option value="Language">Language</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Percentage (0-100) <span class="text-danger">*</span></label>
                        <input type="number" name="percentage" class="form-control" min="0" max="100" placeholder="85" required>
                        <small class="text-muted">Your proficiency level</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon (Bootstrap Icons)</label>
                        <input type="text" name="icon" class="form-control" placeholder="bi-code-slash">
                        <small class="text-muted">
                            Find icons at <a href="https://icons.getbootstrap.com/" target="_blank">icons.getbootstrap.com</a>
                        </small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Optional description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control" value="0" min="0">
                        <small class="text-muted">Lower number appears first</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Skill
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Skill -->
<div class="modal fade" id="editSkillModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Skill</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSkillForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Skill Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category" id="edit_category" class="form-control" required>
                            <option value="">-- Select Category --</option>
                            <option value="Programming">Programming</option>
                            <option value="Database">Database</option>
                            <option value="Technology">Technology</option>
                            <option value="Language">Language</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Percentage (0-100) <span class="text-danger">*</span></label>
                        <input type="number" name="percentage" id="edit_percentage" class="form-control" min="0" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon (Bootstrap Icons)</label>
                        <input type="text" name="icon" id="edit_icon" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" id="edit_display_order" class="form-control" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Update Skill
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function editSkill(id, name, category, percentage, icon, description, display_order) {
    // Set form action
    document.getElementById('editSkillForm').action = `/admin/skills/${id}`;
    
    // Fill form fields
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_category').value = category;
    document.getElementById('edit_percentage').value = percentage;
    document.getElementById('edit_icon').value = icon || '';
    document.getElementById('edit_description').value = description || '';
    document.getElementById('edit_display_order').value = display_order;
}
</script>
@endpush