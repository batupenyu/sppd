<?php

namespace Tests\Unit;

use App\Models\Asn;
use App\Models\DrhSatyalancana;
use Tests\TestCase;

class DrhFlowTest extends TestCase
{
    public function test_store_then_print_shows_data(): void
    {
        $asn = Asn::first();
        if (!$asn) {
            $asn = Asn::create([
                'nama' => 'Al Fikri',
                'nip' => '12345',
                'tempat_lahir' => 'Pangkalpinang',
                'tanggal_lahir' => '1990-01-01',
                'jk' => 'L',
            ]);
        }

        $response = $this->post('/drh-satyalancana', [
            'asn_id' => $asn->id,
            'pendidikan_terakhir' => 'S1 TEST',
            'pangkat' => 'Penata TEST',
            'nip_lama' => '999TEST',
            'atasan_nama' => 'Atasan TEST',
            'atasan_nip' => '888TEST',
        ]);

        $response->assertRedirect();

        $drh = DrhSatyalancana::where('pendidikan_terakhir', 'S1 TEST')->first();
        $this->assertNotNull($drh);
        $this->assertEquals('S1 TEST', $drh->pendidikan_terakhir);

        $print = $this->get($response->headers->get('Location'));
        $print->assertStatus(200);

        $id = $drh->id;
        $printById = $this->get("/drh-satyalancana/{$id}/print");
        $printById->assertStatus(200);

        // Direct render check (bypass HTTP) to isolate view vs routing
        $fresh = \App\Models\DrhSatyalancana::find($id);
        $direct = view('drh_satyalancana.print', ['drh' => $fresh])->render();
        echo "\n[DEBUG] direct has S1 TEST: " . (str_contains($direct, 'S1 TEST') ? 'YES' : 'NO') . "\n";
        echo "[DEBUG] http  has S1 TEST: " . (str_contains($printById->getContent(), 'S1 TEST') ? 'YES' : 'NO') . "\n";
        echo "[DEBUG] db connection: " . \Illuminate\Support\Facades\DB::connection()->getDatabaseName() . "\n";

        $printById->assertSee('S1 TEST');
        $printById->assertSee('Penata TEST');
        $printById->assertSee('Al Fikri');
        $printById->assertSee('Atasan TEST');

        $drh->delete();
    }
}
