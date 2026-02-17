<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-share-alt"></i> Manage Social Links</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSocialLinkModal">
        <i class="fas fa-plus"></i> Add Social Link
    </button>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th width="5%">#</th>
                <th width="10%">Icon</th>
                <th width="20%">Platform</th>
                <th width="35%">URL</th>
                <th width="10%">Status</th>
                <th width="10%">Order</th>
                <th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($socialLinks as $index => $link)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-center">
                    <i class="{{ $link->icon }} fa-2x"></i>
                </td>
                <td><strong>{{ $link->platform }}</strong></td>
                <td>
                    <a href="{{ $link->url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 300px;">
                        {{ $link->url }}
                    </a>
                    <a href="{{ $link->url }}" target="_blank" class="ms-2">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </td>
                <td>
                    @if($link->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>{{ $link->display_order }}</td>
                <td>
                    <button class="btn btn-sm btn-warning mb-1" 
                            onclick="editSocialLink({{ json_encode($link) }})"
                            data-bs-toggle="modal" 
                            data-bs-target="#editSocialLinkModal">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.social-links.destroy', $link->id) }}" 
                          method="POST" 
                          style="display: inline-block;"
                          onsubmit="return confirm('Delete this social link?')">
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
                    <i class="fas fa-share-alt fa-3x mb-3 d-block"></i>
                    No social links found. Add your first social link!
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addSocialLinkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Add New Social Link</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.social-links.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Platform <span class="text-danger">*</span></label>
                        <select name="platform" id="add_platform" class="form-control" onchange="updateIcon('add')" required>
                            <option value="">-- Select Platform --</option>
                            <option value="Twitter">Twitter / X</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Instagram">Instagram</option>
                            <option value="LinkedIn">LinkedIn</option>
                            <option value="GitHub">GitHub</option>
                            <option value="YouTube">YouTube</option>
                            <option value="TikTok">TikTok</option>
                            <option value="WhatsApp">WhatsApp</option>
                            <option value="Telegram">Telegram</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL <span class="text-danger">*</span></label>
                        <input type="url" name="url" class="form-control" placeholder="https://twitter.com/yourname" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon (Bootstrap Icons) <span class="text-danger">*</span></label>
                        <input type="text" name="icon" id="add_icon" class="form-control" placeholder="bi-twitter-x" required>
                        <small class="text-muted">
                            Find icons at <a href="https://icons.getbootstrap.com/" target="_blank">icons.getbootstrap.com</a>
                        </small>
                        <div class="mt-2">
                            <span class="text-muted">Preview: </span>
                            <i id="add_icon_preview" class="fa-2x"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="add_is_active" checked>
                                    <label class="form-check-label" for="add_is_active">Active</label>
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
                    <button type="submit" class="btn btn-primary">Save Social Link</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editSocialLinkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Social Link</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSocialLinkForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Platform <span class="text-danger">*</span></label>
                        <input type="text" name="platform" id="edit_platform" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL <span class="text-danger">*</span></label>
                        <input type="url" name="url" id="edit_url" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon (Bootstrap Icons) <span class="text-danger">*</span></label>
                        <input type="text" name="icon" id="edit_icon" class="form-control" required>
                        <div class="mt-2">
                            <span class="text-muted">Preview: </span>
                            <i id="edit_icon_preview" class="fa-2x"></i>
                        </div>
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
                    <button type="submit" class="btn btn-warning">Update Social Link</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
const platformIcons = {
    'Twitter': 'bi-twitter-x',
    'Facebook': 'bi-facebook',
    'Instagram': 'bi-instagram',
    'LinkedIn': 'bi-linkedin',
    'GitHub': 'bi-github',
    'YouTube': 'bi-youtube',
    'TikTok': 'bi-tiktok',
    'WhatsApp': 'bi-whatsapp',
    'Telegram': 'bi-telegram'
};

function updateIcon(prefix) {
    const platform = document.getElementById(prefix + '_platform').value;
    const iconInput = document.getElementById(prefix + '_icon');
    const iconPreview = document.getElementById(prefix + '_icon_preview');
    
    if (platformIcons[platform]) {
        iconInput.value = platformIcons[platform];
        iconPreview.className = platformIcons[platform] + ' fa-2x';
    }
}

// Live preview for icon input
document.getElementById('add_icon').addEventListener('input', function() {
    document.getElementById('add_icon_preview').className = this.value + ' fa-2x';
});

document.getElementById('edit_icon').addEventListener('input', function() {
    document.getElementById('edit_icon_preview').className = this.value + ' fa-2x';
});

function editSocialLink(link) {
    document.getElementById('editSocialLinkForm').action = `/admin/social-links/${link.id}`;
    document.getElementById('edit_platform').value = link.platform;
    document.getElementById('edit_url').value = link.url;
    document.getElementById('edit_icon').value = link.icon;
    document.getElementById('edit_icon_preview').className = link.icon + ' fa-2x';
    document.getElementById('edit_display_order').value = link.display_order;
    document.getElementById('edit_is_active').checked = link.is_active;
}
</script>
@endpush