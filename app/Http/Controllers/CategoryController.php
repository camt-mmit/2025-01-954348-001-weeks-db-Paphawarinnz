<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Psr\Http\Message\ServerRequestInterface;

class CategoryController extends SearchableController
{
    const int MAX_ITEMS = 5;
    #[\Override]
    function getQuery(): Builder
    {
        return Category::orderBy('code');
    }

    #[\Override]
    function prepareCriteria(array $criteria): array
    {
        return [
            ...parent::prepareCriteria($criteria),
            'minPrice' => (($criteria['minPrice'] ?? null) === null)
                ? null
                : (float) $criteria['minPrice'],
            'maxPrice' => (($criteria['maxPrice'] ?? null) === null)
                ? null
                : (float) $criteria['maxPrice'],
        ];
    }

    function filterByPrice(
        Builder|Relation $query,
        ?float $minPrice,
        ?float $maxPrice
    ): Builder|Relation {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query;
    }

    #[\Override]
    function filter(Builder|Relation $query, array $criteria): Builder|Relation
    {
        $query = parent::filter($query, $criteria);
        $query = $this->filterByPrice(
            $query,
            $criteria['minPrice'],
            $criteria['maxPrice'],
        );

        return $query;
    }

    function list(ServerRequestInterface $request): View
    {
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria)->withCount('products');


        return view('categories.list', [
            'criteria' => $criteria,
            'category' => $query->paginate(self::MAX_ITEMS),
        ]);
    }

    function view(string $categoryCode): View
    {
        $category = $this->find($categoryCode);


        return view('categories.view', [
            'category' => $category,
        ]);
    }

    function showCreateForm(): View
    {
        return view('categories.create-form');
    }

    function create(ServerRequestInterface $request): RedirectResponse
    {
        $category = Category::create($request->getParsedBody());

        return redirect()->route('categories.list');
    }

    function showUpdateForm(string $categoryCode): View
    {
        $category = $this->find($categoryCode);

        return view('categories.update-form', [
            'category' => $category,
        ]);
    }

    function update(
        ServerRequestInterface $request,
        string $categoriesCode,
    ): RedirectResponse {
        $category = $this->find($categoriesCode);
        $category->fill($request->getParsedBody());
        $category->save();

        return redirect()->route('categories.view', [
            'category' => $category->code,
        ]);
    }

    function delete(string $categoryCode): RedirectResponse
    {
        $category = $this->find($categoryCode);
        $category->delete();

        return redirect()->route('categories.list');
    }

     function viewProducts(
        ServerRequestInterface $request,
        ProductController $productController,
        string $categoryCode
    ): View {
        $category = $this->find($categoryCode);
        $criteria = $productController->prepareCriteria($request->getQueryParams());
        $query = $productController

            ->filter($category->products(), $criteria)
            ->withCount('products');
        return view('categories.view-products', [
            'category' => $category,
            'criteria' => $criteria,
            'products' => $query->paginate($productController::MAX_ITEMS),
        ]);
    }
}
