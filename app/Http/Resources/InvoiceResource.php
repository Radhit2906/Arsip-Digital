<?php

// namespace App\Http\Resources;

// use Illuminate\Http\Resources\Json\JsonResource;

// class InvoiceResource extends JsonResource
// {
//     // //define properti
//     // public $status;
//     // public $message;
//     // public $resource;
    
//     // /**
//     //  * __construct
//     //  *
//     //  * @param  mixed $status
//     //  * @param  mixed $message
//     //  * @param  mixed $resource
//     //  * @return void
//     //  */
//     // public function __construct($status, $message, $resource)
//     // {
//     //     parent::__construct($resource);
//     //     $this->status  = $status;
//     //     $this->message = $message;
//     // }

//     // /**
//     //  * Transform the resource into an array.
//     //  *
//     //  * @param  \Illuminate\Http\Request  $request
//     //  * @return array
//     //  */
//     public function toArray($request)
//     {
//         return [
//             'id'   => $this->id,
//             'id_invoice'   => $this->id_invoice,
//             'kategori'      => $this->kategori,
//             'date'      => $this->date,
//             'seller'      => $this->seller,
//             'alamat_seller'      => $this->alamat_seller,
//             'payer'      => $this->payer,
//             'alamat_payer'      => $this->alamat_payer,
//             'keterangan'      => $this->keterangan,
//             'pdf_file'      => $this->pdf_file
//         ];
//     }
// }