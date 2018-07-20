<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\Transaction;
use App\Transformers\TransactionTransformer;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{
    /**
     * ProductBuyerTransactionController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . TransactionTransformer::class)->only(['store']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Product $product
     * @param User $buyer
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, User $buyer)
    {
        $validation_rules = [
            'quantity' => 'required|integer|min:1'
        ];

        $this->validate($request, $validation_rules);

        if ($buyer->id == $product->seller_id) {
            return $this->errorResponse('El comprador debe ser diferente al vendedor', 409);
        }

        if ( ! $buyer->isVerificado()) {
            return $this->errorResponse('El comprador debe ser un usuario verificado', 409);
        }

        if ( ! $product->seller->isVerificado()) {
            return $this->errorResponse('El vendedor debe ser un usuario verificado', 409);
        }

        if ( ! $product->isDisponible()) {
            return $this->errorResponse('El producto solicitado no se encuentra disponible', 409);
        }

        if ($product->quantity < $request->quantity) {
            return $this->errorResponse('El producto no tiene suficiente inventario para la cantidad solicitada',
                409);
        }

        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id
            ]);

            return $this->showOne($transaction, 201);
        });
    }
}
