<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-graduation-cap"></i> Manage Educations</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEducationModal">
        <i class="fas fa-plus"></i> Add Education
    </button>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th width="5%">#</th>
                <th width="25%">Degree</th>
                <th width="25%">Institution</th>
                <th width="15%">Period</th>
                <th width="10%">Order</th>
                <th width="20%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($educations as $index => $edu)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $edu->degree }}</strong></td>
                <td>{{ $edu->institution }}</td>
                <td>
                    @if($edu->start_year == $edu->end_year)
                        {{ $edu->start_year }}
                    @else
                        {{ $edu->start_year }} - {{ $edu->end_year ?? 'Present' }}
                    @endif
                </td>
                <td>{{ $edu->display_order }}</td>
                <td>
                    <button class="btn btn-sm btn-warning mb-1" 
                            onclick="editEducation({{ json_encode($edu) }})"
                            data-bs-toggle="modal" 
                            data-bs-target="#editEducationModal">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.educations.destroy', $edu->id) }}" 
                          method="POST" 
                          style="display: inline-block;"
                          onsubmit="return confirm('Delete this education?')">
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
                <td colspan="6" class="text-center text-muted">
                    <i class="fas fa-graduation-cap fa-3x mb-3 d-block"></i>
                    No educations found. Add your first education!
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addEducationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Add New Education</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.educations.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Degree <span class="text-danger">*</span></label>
                        <input type="text" name="degree" class="form-control" placeholder="e.g., Bachelor of Computer Science" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Institution <span class="text-danger">*</span></label>
                        <input type="text" name="institution" class="form-control" placeholder="e.g., University Name" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Start Year <span class="text-danger">*</span></label>
                                <input type="number" name="start_year" class="form-control" min="1900" max="2100" placeholder="2018" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">End Year</label>
                                <input type="number" name="end_year" class="form-control" min="1900" max="2100" placeholder="2022">
                                <small class="text-muted">Leave empty if ongoing</small>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Optional description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control" value="0" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Education</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editEducationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Education</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editEducationForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Degree <span class="text-danger">*</span></label>
                        <input type="text" name="degree" id="edit_degree" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Institution <span class="text-danger">*</span></label>
                        <input type="text" name="institution" id="edit_institution" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Start Year <span class="text-danger">*</span></label>
                                <input type="number" name="start_year" id="edit_start_year" class="form-control" min="1900" max="2100" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">End Year</label>
                                <input type="number" name="end_year" id="edit_end_year" class="form-control" min="1900" max="2100">
                            </div>
                        </div>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Update Education</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function editEducation(edu) {
    document.getElementById('editEducationForm').action = `/admin/educations/${edu.id}`;
    document.getElementById('edit_degree').value = edu.degree;
    document.getElementById('edit_institution').value = edu.institution;
    document.getElementById('edit_start_year').value = edu.start_year;
    document.getElementById('edit_end_year').value = edu.end_year || '';
    document.getElementById('edit_description').value = edu.description || '';
    document.getElementById('edit_display_order').value = edu.display_order;
}
</script>
@endpush