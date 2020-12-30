<?php

namespace Module\Seo\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Module\Seo\Http\Requests\PreRedirectRequest;
use Module\Seo\Repositories\PreRedirectRepositoryInterface;

class PreRedirectController extends Controller
{
    /**
     * @var PreRedirectRepositoryInterface
     */
    protected $preRedirectRepository;

    public function __construct(PreRedirectRepositoryInterface $preRedirectRepository)
    {
        $this->preRedirectRepository = $preRedirectRepository;
    }

    public function index(Request $request)
    {
        $items = $this->preRedirectRepository->paginate($request->input('max', 20));

        return view('seo::admin.pre-redirect.index', compact('items'));
    }

    public function create()
    {
        return view('seo::admin.pre-redirect.create');
    }

    public function store(PreRedirectRequest $request)
    {
        $item = $this->preRedirectRepository->create($request->all());

        if ($request->input('continue')) {
            return redirect()
                ->route('seo.admin.pre-redirect.edit', $item->id)
                ->with('success', __('seo::pre-redirect.notification.created'));
        }

        return redirect()
            ->route('seo.admin.pre-redirect.index')
            ->with('success', __('seo::pre-redirect.notification.created'));
    }

    public function edit($id)
    {
        $item = $this->preRedirectRepository->find($id);

        return view('seo::admin.pre-redirect.edit', compact('item'));
    }

    public function update(PreRedirectRequest $request, $id)
    {
        $item = $this->preRedirectRepository->updateById($request->all(), $id);

        if ($request->input('continue')) {
            return redirect()
                ->route('seo.admin.pre-redirect.edit', $item->id)
                ->with('success', __('seo::pre-redirect.notification.updated'));
        }

        return redirect()
            ->route('seo.admin.pre-redirect.index')
            ->with('success', __('seo::pre-redirect.notification.updated'));
    }

    public function destroy($id, Request $request)
    {
        $this->preRedirectRepository->delete($id);

        if ($request->wantsJson()) {
            Session::flash('success', __('seo::pre-redirect.notification.deleted'));
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()
            ->route('seo.admin.pre-redirect.index')
            ->with('success', __('seo::pre-redirect.notification.deleted'));
    }
}
