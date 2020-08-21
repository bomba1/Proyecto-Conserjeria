<?php
/*
 * MIT License
 *
 * Copyright (c) 2020 Leon-Salas-Santander
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

use App\Visita;
use Illuminate\Database\Seeder;

class VisitaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Visita::create([
            'fecha' => '2018-12-31 13:05:21',
            'parentesco' => 'familia',
            'empresa_reparto' => 'NO',
            'persona_id' => 1,
            'propiedad_id' => 1
        ]);

        Visita::create([
            'fecha' => '2019-12-31 13:05:21',
            'parentesco' => 'familia',
            'empresa_reparto' => 'NO',
            'persona_id' => 1,
            'propiedad_id' => 1
        ]);

        Visita::create([
            'fecha' => '2020-12-31 13:05:21',
            'parentesco' => 'empresa',
            'empresa_reparto' => 'SI',
            'persona_id' => 2,
            'propiedad_id' => 3
        ]);

        Visita::create([
            'fecha' => '2019-12-31 13:05:21',
            'parentesco' => 'familia',
            'empresa_reparto' => 'NO',
            'persona_id' => 1,
            'propiedad_id' => 1
        ]);

        Visita::create([
            'fecha' => '2017-12-31 13:05:21',
            'parentesco' => 'familia',
            'empresa_reparto' => 'NO',
            'persona_id' => 1,
            'propiedad_id' => 1
        ]);

        Visita::create([
            'fecha' => '2015-12-31 13:05:21',
            'parentesco' => 'empresa',
            'empresa_reparto' => 'SI',
            'persona_id' => 2,
            'propiedad_id' => 3
        ]);
    }
}
