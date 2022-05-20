<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notasfiscais extends Model
{
    use HasFactory;

    protected $fillable = ['id,',
                           'venda_id',
                           'valor',
                           'imposto'];

    protected $table = 'notasfiscais';

    public function venda(){

        return $this->hasOne(vendas::class, 'id' );
    }

}
