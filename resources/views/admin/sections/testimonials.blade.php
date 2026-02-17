<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-comment"></i> Manage Testimonials</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTestimonialModal">
        <i class="fas fa-plus"></i> Add Testimonial
    </button>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th width="5%">#</th>
                <th width="10%">Avatar</th>
                <th width="20%">Name</th>
                <th width="15%">Position</th>
                <th width="10%">Rating</th>
                <th width="10%">Type</th>
                <th width="10%">Status</th>
                <th width="20%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($testimonials as $index => $test)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    @if($test->avatar)
                    <img src="{{ asset('assets/img/person/'.$test->avatar) }}" 
                         class="rounded-circle" 
                         style="width: 50px; height: 50px; object-fit: cover;"
                         alt="{{ $test->name }}"
                         loading="lazy">
                    @else
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px;">
                        {{ substr($test->name, 0, 1) }}
                    </div>
                    @endif
                </td>
                <td>
                    <strong>{{ $test->name }}</strong>
                    @if($test->is_critic && $test->critic_name)
                        <br><small class="text-muted">{{ $test->critic_name }}</small>
                    @endif
                </td>
                <td>
                    {{ $test->position ?? '-' }}
                    @if($test->company)
                        <br><small class="text-muted">{{ $test->company }}</small>
                    @endif
                </td>
                <td>
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $test->rating)
                            <i class="fas fa-star text-warning"></i>
                        @else
                            <i class="far fa-star text-muted"></i>
                        @endif
                    @endfor
                </td>
                <td>
                    @if($test->is_critic)
                        <span class="badge bg-info">Critic</span>
                    @else
                        <span class="badge bg-secondary">Personal</span>
                    @endif
                </td>
                <td>
                    @if($test->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-sm btn-warning mb-1" 
                            onclick="editTestimonial({{ json_encode($test) }})"
                            data-bs-toggle="modal" 
                            data-bs-target="#editTestimonialModal">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.testimonials.destroy', $test->id) }}" 
                          method="POST" 
                          style="display: inline-block;"
                          onsubmit="return confirm('Delete this testimonial?')">
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
                <td colspan="8" class="text-center text-muted">
                    <i class="fas fa-comment fa-3x mb-3 d-block"></i>
                    No testimonials found. Add your first testimonial!
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addTestimonialModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Add New Testimonial</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Position</label>
                                <input type="text" name="position" class="form-control" placeholder="CEO">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Company</label>
                                <input type="text" name="company" class="form-control" placeholder="Company Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rating <span class="text-danger">*</span></label>
                                <select name="rating" class="form-control" required>
                                    <option value="5">⭐⭐⭐⭐⭐ (5 stars)</option>
                                    <option value="4">⭐⭐⭐⭐ (4 stars)</option>
                                    <option value="3">⭐⭐⭐ (3 stars)</option>
                                    <option value="2">⭐⭐ (2 stars)</option>
                                    <option value="1">⭐ (1 star)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Review Text <span class="text-danger">*</span></label>
                        <textarea name="review_text" class="form-control" rows="4" placeholder="Write the testimonial..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Avatar Image</label>
                        <input type="file" name="avatar" id="add_avatar" class="form-control" accept="image/*" onchange="previewAvatar(this, 'add_avatar_preview')">
                        <small class="text-muted">Max 5MB. JPG, PNG, GIF, or WEBP. Will be compressed automatically.</small>
                        
                        <!-- Avatar Preview -->
                        <div id="add_avatar_preview" class="mt-2" style="display: none;">
                            <img src="" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                            <button type="button" class="btn btn-sm btn-danger ms-2" onclick="removeAvatarPreview('add_avatar', 'add_avatar_preview')">
                                <i class="fas fa-times"></i> Remove
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_critic" value="1" class="form-check-input" id="add_is_critic" onchange="toggleCriticField(this, 'add_critic_name')">
                            <label class="form-check-label" for="add_is_critic">
                                <i class="fas fa-newspaper"></i> This is a critic/media review
                            </label>
                        </div>
                    </div>
                    <div class="mb-3" id="add_critic_name_group" style="display: none;">
                        <label class="form-label">Media/Publication Name</label>
                        <input type="text" name="critic_name" id="add_critic_name" class="form-control" placeholder="e.g., The New York Times">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="add_is_active" checked>
                                    <label class="form-check-label" for="add_is_active">Active (visible on website)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Display Order</label>
                                <input type="number" name="display_order" class="form-control" value="0" min="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Testimonial</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editTestimonialModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Testimonial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editTestimonialForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="edit_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Position</label>
                                <input type="text" name="position" id="edit_position" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Company</label>
                                <input type="text" name="company" id="edit_company" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rating <span class="text-danger">*</span></label>
                                <select name="rating" id="edit_rating" class="form-control" required>
                                    <option value="5">⭐⭐⭐⭐⭐ (5 stars)</option>
                                    <option value="4">⭐⭐⭐⭐ (4 stars)</option>
                                    <option value="3">⭐⭐⭐ (3 stars)</option>
                                    <option value="2">⭐⭐ (2 stars)</option>
                                    <option value="1">⭐ (1 star)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Review Text <span class="text-danger">*</span></label>
                        <textarea name="review_text" id="edit_review_text" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Change Avatar</label>
                        <input type="file" name="avatar" id="edit_avatar" class="form-control" accept="image/*" onchange="previewAvatar(this, 'edit_avatar_preview')">
                        <small class="text-muted">Leave empty to keep current avatar. Max 5MB.</small>
                        
                        <!-- Current Avatar Preview -->
                        <div id="edit_current_avatar_preview" class="mt-2"></div>
                        
                        <!-- New Avatar Preview -->
                        <div id="edit_avatar_preview" class="mt-2" style="display: none;">
                            <p class="text-success mb-1"><strong>New Avatar:</strong></p>
                            <img src="" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                            <button type="button" class="btn btn-sm btn-danger ms-2" onclick="removeAvatarPreview('edit_avatar', 'edit_avatar_preview')">
                                <i class="fas fa-times"></i> Remove
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_critic" value="1" class="form-check-input" id="edit_is_critic" onchange="toggleCriticField(this, 'edit_critic_name')">
                            <label class="form-check-label" for="edit_is_critic">This is a critic/media review</label>
                        </div>
                    </div>
                    <div class="mb-3" id="edit_critic_name_group" style="display: none;">
                        <label class="form-label">Media/Publication Name</label>
                        <input type="text" name="critic_name" id="edit_critic_name" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="edit_is_active">
                                    <label class="form-check-label" for="edit_is_active">Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Display Order</label>
                                <input type="number" name="display_order" id="edit_display_order" class="form-control" min="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Update Testimonial</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Preview avatar before upload
function previewAvatar(input, previewId) {
    const preview = document.getElementById(previewId);
    const previewImg = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove avatar preview
function removeAvatarPreview(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    
    input.value = '';
    preview.style.display = 'none';
}

function toggleCriticField(checkbox, fieldId) {
    const group = document.getElementById(fieldId + '_group');
    if (checkbox.checked) {
        group.style.display = 'block';
    } else {
        group.style.display = 'none';
        document.getElementById(fieldId).value = '';
    }
}

function editTestimonial(test) {
    document.getElementById('editTestimonialForm').action = `/admin/testimonials/${test.id}`;
    document.getElementById('edit_name').value = test.name;
    document.getElementById('edit_position').value = test.position || '';
    document.getElementById('edit_company').value = test.company || '';
    document.getElementById('edit_rating').value = test.rating;
    document.getElementById('edit_review_text').value = test.review_text;
    document.getElementById('edit_display_order').value = test.display_order;
    document.getElementById('edit_is_active').checked = test.is_active;
    document.getElementById('edit_is_critic').checked = test.is_critic;
    document.getElementById('edit_critic_name').value = test.critic_name || '';
    
    toggleCriticField(document.getElementById('edit_is_critic'), 'edit_critic_name');
    
    // Show current avatar
    const currentPreview = document.getElementById('edit_current_avatar_preview');
    if (test.avatar) {
        currentPreview.innerHTML = `
            <p class="mb-1"><strong>Current Avatar:</strong></p>
            <img src="/assets/img/person/${test.avatar}" 
                 class="rounded-circle" 
                 style="width: 100px; height: 100px; object-fit: cover;" 
                 loading="lazy">
        `;
    } else {
        currentPreview.innerHTML = '<p class="text-muted">No avatar</p>';
    }
    
    // Reset new avatar preview
    document.getElementById('edit_avatar').value = '';
    document.getElementById('edit_avatar_preview').style.display = 'none';
}
</script>
@endpush