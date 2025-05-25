use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');

            $table->string('transaction_number')->unique();
            $table->decimal('total', 15, 2);
            $table->decimal('ppn', 15, 2);
            $table->decimal('grand_total', 15, 2);
            $table->string('status')->default('pending');

            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->string('proof_of_payment')->nullable();

            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
