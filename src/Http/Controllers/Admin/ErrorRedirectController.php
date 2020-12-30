<?php

namespace Module\Seo\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Module\Seo\Http\Requests\ErrorRedirectRequest;
use Module\Seo\Repositories\ErrorRedirectRepositoryInterface;

class ErrorRedirectController extends Controller
{
    /**
     * @var ErrorRedirectRepositoryInterface
     */
    protected $errorRedirectRepository;

    public function __construct(ErrorRedirectRepositoryInterface $errorRedirectRepository)
    {
        $this->errorRedirectRepository = $errorRedirectRepository;
    }

    public function index(Request $request)
    {
        $items = $this->errorRedirectRepository->paginate($request->input('max', 20));

        return view('seo::admin.error-redirect.index', compact('items'));
    }

    public function create()
    {
        return view('seo::admin.error-redirect.create');
    }

    public function store(ErrorRedirectRequest $request)
    {
        $item = $this->errorRedirectRepository->create($request->all());

        if ($request->input('continue')) {
            return redirect()
                ->route('seo.admin.error-redirect.edit', $item->id)
                ->with('success', __('seo::message.notification.created'));
        }

        return redirect()
            ->route('seo.admin.error-redirect.index')
            ->with('success', __('seo::message.notification.created'));
    }

    public function edit($id)
    {
        $item = $this->errorRedirectRepository->find($id);

        return view('seo::admin.error-redirect.edit', compact('item'));
    }

    public function update(ErrorRedirectRequest $request, $id)
    {
        $item = $this->errorRedirectRepository->updateById($request->all(), $id);

        if ($request->input('continue')) {
            return redirect()
                ->route('seo.admin.error-redirect.edit', $item->id)
                ->with('success', __('seo::message.notification.updated'));
        }

        return redirect()
            ->route('seo.admin.error-redirect.index')
            ->with('success', __('seo::message.notification.updated'));
    }

    public function destroy($id, Request $request)
    {
        $this->errorRedirectRepository->delete($id);

        if ($request->wantsJson()) {
            Session::flash('success', __('seo::message.notification.deleted'));
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()
            ->route('seo.admin.error-redirect.index')
            ->with('success', __('seo::message.notification.deleted'));
    }
}
