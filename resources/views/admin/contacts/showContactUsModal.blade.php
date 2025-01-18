<div class="modal fade" id="modalCenter-{{ $contact->id }}" tabindex="-1"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">
                    {{ trans('dashboard.admins.message') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            <div class="modal-body pd-20">
                <div class="row">
                    <div class="col-10">
                        {{ $contact->message }}
                    </div>
                </div>

            </div><!-- modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ trans('dashboard.close') }}</button>
            </div>
        </div>
    </div>
</div>
