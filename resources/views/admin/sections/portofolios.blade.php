<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-briefcase"></i> Manage Portfolios</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPortfolioModal">
        <i class="fas fa-plus"></i> Add Portfolio
    </button>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th width="5%">#</th>
                <th width="10%">Image</th>
                <th width="20%">Title</th>
                <th width="15%">Category</th>
                <th width="15%">Tags</th>
                <th width="10%">Featured</th>
                <th width="10%">Order</th>
                <th width="15%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($portfolios as $index => $portfolio)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    @if($portfolio->image)
                    <img src="{{ asset('assets/img/portfolio/'.$portfolio->image) }}" 
                         class="img-thumbnail" 
                         style="width: 60px; height: 60px; object-fit: cover;"
                         alt="{{ $portfolio->title }}" 
                         loading="lazy">
                    @else
                    <div class="bg-light text-center" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-image text-muted"></i>
                    </div>
                    @endif
                </td>
                <td>
                    <strong>{{ $portfolio->title }}</strong>
                    @if($portfolio->project_url)
                    <br><small><a href="{{ $portfolio->project_url }}" target="_blank"><i class="fas fa-external-link-alt"></i> View</a></small>
                    @endif
                </td>
                <td><span class="badge bg-info">{{ $portfolio->category }}</span></td>
                <td>
                    @if($portfolio->tags)
                        @foreach($portfolio->tags as $tag)
                            <span class="badge bg-secondary">{{ $tag }}</span>
                        @endforeach
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    @if($portfolio->is_featured)
                        <span class="badge bg-warning"><i class="fas fa-star"></i> Featured</span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>{{ $portfolio->display_order }}</td>
                <td>
                    <button class="btn btn-sm btn-warning mb-1" 
                            onclick="editPortfolio({{ json_encode($portfolio) }})"
                            data-bs-toggle="modal" 
                            data-bs-target="#editPortfolioModal">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.portfolios.destroy', $portfolio->id) }}" 
                          method="POST" 
                          style="display: inline-block;"
                          onsubmit="return confirm('Delete this portfolio?')">
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
                    <i class="fas fa-briefcase fa-3x mb-3 d-block"></i>
                    No portfolios found. Add your first portfolio!
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Add Portfolio -->
<div class="modal fade" id="addPortfolioModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Add New Portfolio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="e.g., E-commerce Website" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="category" class="form-control" required>
                                    <option value="">-- Select Category --</option>
                                    <option value="Design">Design</option>
                                    <option value="Development">Development</option>
                                    <option value="Photo & Video">Photo & Video</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Project description"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Project URL</label>
                        <input type="url" name="project_url" class="form-control" placeholder="https://example.com">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tags (separate with comma)</label>
                        <input type="text" id="add_tags_input" class="form-control" placeholder="laravel, vue, api">
                        <small class="text-muted">e.g., laravel, vue, api</small>
                        <div id="add_tags_container" class="mt-2"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Project Image</label>
                        <input type="file" name="image" id="add_portfolio_image" class="form-control" accept="image/*" onchange="previewPortfolioImage(this, 'add_portfolio_preview')">
                        <small class="text-muted">Max 5MB. JPG, PNG, GIF, or WEBP. Will be compressed automatically.</small>
                        
                        <!-- Image Preview -->
                        <div id="add_portfolio_preview" class="mt-2" style="display: none;">
                            <img src="" class="img-thumbnail" style="max-width: 300px;">
                            <button type="button" class="btn btn-sm btn-danger ms-2" onclick="removePortfolioPreview('add_portfolio_image', 'add_portfolio_preview')">
                                <i class="fas fa-times"></i> Remove
                            </button>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="add_is_featured">
                                    <label class="form-check-label" for="add_is_featured">
                                        <i class="fas fa-star text-warning"></i> Featured Portfolio
                                    </label>
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
                    <button type="submit" class="btn btn-primary">Save Portfolio</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Portfolio -->
<div class="modal fade" id="editPortfolioModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Portfolio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editPortfolioForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="edit_title" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="category" id="edit_category" class="form-control" required>
                                    <option value="">-- Select Category --</option>
                                    <option value="Design">Design</option>
                                    <option value="Development">Development</option>
                                    <option value="Photo & Video">Photo & Video</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Project URL</label>
                        <input type="url" name="project_url" id="edit_project_url" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tags (separate with comma)</label>
                        <input type="text" id="edit_tags_input" class="form-control">
                        <div id="edit_tags_container" class="mt-2"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Change Image</label>
                        <input type="file" name="image" id="edit_portfolio_image" class="form-control" accept="image/*" onchange="previewPortfolioImage(this, 'edit_portfolio_preview')">
                        <small class="text-muted">Leave empty to keep current image. Max 5MB.</small>
                        
                        <!-- Current Image Preview -->
                        <div id="edit_current_portfolio_preview" class="mt-2"></div>
                        
                        <!-- New Image Preview -->
                        <div id="edit_portfolio_preview" class="mt-2" style="display: none;">
                            <p class="text-success mb-1"><strong>New Image:</strong></p>
                            <img src="" class="img-thumbnail" style="max-width: 300px;">
                            <button type="button" class="btn btn-sm btn-danger ms-2" onclick="removePortfolioPreview('edit_portfolio_image', 'edit_portfolio_preview')">
                                <i class="fas fa-times"></i> Remove
                            </button>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="edit_is_featured">
                                    <label class="form-check-label" for="edit_is_featured">
                                        <i class="fas fa-star text-warning"></i> Featured Portfolio
                                    </label>
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
                    <button type="submit" class="btn btn-warning">Update Portfolio</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Preview portfolio image before upload
function previewPortfolioImage(input, previewId) {
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

// Remove portfolio preview
function removePortfolioPreview(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    
    input.value = '';
    preview.style.display = 'none';
}

// Handle tags input for Add form
document.getElementById('add_tags_input').addEventListener('blur', function() {
    const tagsStr = this.value.trim();
    if (tagsStr) {
        const tags = tagsStr.split(',').map(t => t.trim()).filter(t => t);
        const container = document.getElementById('add_tags_container');
        container.innerHTML = '';
        tags.forEach((tag, index) => {
            container.innerHTML += `<input type="hidden" name="tags[]" value="${tag}">`;
            container.innerHTML += `<span class="badge bg-secondary me-1">${tag}</span>`;
        });
    }
});

function editPortfolio(portfolio) {
    // Set form action
    document.getElementById('editPortfolioForm').action = `/admin/portfolios/${portfolio.id}`;
    
    // Fill form fields
    document.getElementById('edit_title').value = portfolio.title;
    document.getElementById('edit_category').value = portfolio.category || '';
    document.getElementById('edit_description').value = portfolio.description || '';
    document.getElementById('edit_project_url').value = portfolio.project_url || '';
    document.getElementById('edit_display_order').value = portfolio.display_order;
    document.getElementById('edit_is_featured').checked = portfolio.is_featured;
    
    // Handle tags
    const tagsInput = document.getElementById('edit_tags_input');
    const tagsContainer = document.getElementById('edit_tags_container');
    
    if (portfolio.tags && portfolio.tags.length > 0) {
        tagsInput.value = portfolio.tags.join(', ');
        tagsContainer.innerHTML = '';
        portfolio.tags.forEach(tag => {
            tagsContainer.innerHTML += `<input type="hidden" name="tags[]" value="${tag}">`;
            tagsContainer.innerHTML += `<span class="badge bg-secondary me-1">${tag}</span>`;
        });
    } else {
        tagsInput.value = '';
        tagsContainer.innerHTML = '';
    }
    
    // Show current image
    const currentPreview = document.getElementById('edit_current_portfolio_preview');
    if (portfolio.image) {
        currentPreview.innerHTML = `
            <p class="mb-1"><strong>Current Image:</strong></p>
            <img src="/assets/img/portfolio/${portfolio.image}" 
                 class="img-thumbnail" 
                 style="max-width: 300px;" 
                 loading="lazy">
        `;
    } else {
        currentPreview.innerHTML = '<p class="text-muted">No image</p>';
    }
    
    // Reset new image preview
    document.getElementById('edit_portfolio_image').value = '';
    document.getElementById('edit_portfolio_preview').style.display = 'none';
}

// Handle tags for edit form
document.getElementById('edit_tags_input').addEventListener('blur', function() {
    const tagsStr = this.value.trim();
    if (tagsStr) {
        const tags = tagsStr.split(',').map(t => t.trim()).filter(t => t);
        const container = document.getElementById('edit_tags_container');
        container.innerHTML = '';
        tags.forEach(tag => {
            container.innerHTML += `<input type="hidden" name="tags[]" value="${tag}">`;
            container.innerHTML += `<span class="badge bg-secondary me-1">${tag}</span>`;
        });
    }
});
</script>
@endpush