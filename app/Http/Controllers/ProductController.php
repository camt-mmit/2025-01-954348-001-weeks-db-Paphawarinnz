<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Psr\Http\Message\ServerRequestInterface;

class ProductController extends SearchableController
{
    const int MAX_ITEMS = 5;
    #[\Override]
    function getQuery(): Builder
    {
        return Product::orderBy('code');
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
        Builder $query,
        ?float $minPrice,
        ?float $maxPrice
    ): Builder {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query;
    }

    #[\Override]
    function filter(Builder $query, array $criteria): Builder
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
        $query = $this->search($criteria);


        return view('products.list', [
            'criteria' => $criteria,
            'products' => $query->paginate(self::MAX_ITEMS),
        ]);
    }

    function view(string $productCode): View
    {
        $product = $this->find($productCode);


        return view('products.view', [
            'product' => $product,
        ]);
    }

    function showCreateForm(): View
    {
        return view('products.create-form');
    }

    function create(ServerRequestInterface $request): RedirectResponse
    {
        $product = Product::create($request->getParsedBody());

        return redirect()->route('products.list');
    }

    function showUpdateForm(string $productCode): View
    {
        $product = $this->find($productCode);

        return view('products.update-form', [
            'product' => $product,
        ]);
    }

    function update(
        ServerRequestInterface $request,
        string $productCode,
    ): RedirectResponse {
        $product = $this->find($productCode);
        $product->fill($request->getParsedBody());
        $product->save();

        return redirect()->route('products.view', [
            'product' => $product->code,
        ]);
    }

    function delete(string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);
        $product->delete();

        return redirect()->route('products.list');
    }
}
