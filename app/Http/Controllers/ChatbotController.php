<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function reply(Request $request)
    {
        $userMessage = $request->input('message');

        // 1. MÓC DỮ LIỆU TỪ DATABASE (Theo cấu trúc mới: bảng products chứa name, variants chứa price và stock)
        $products = Product::with('variants')
            ->orderBy('id', 'desc')
            ->take(100)
            ->get();

        // 2. BIẾN DỮ LIỆU THÀNH CHỮ CHO AI ĐỌC 
        $productData = "";
        foreach ($products as $p) {
            $price = 0;
            $stock = 0;
            if ($p->variants->isNotEmpty()) {
                $price = $p->variants->first()->price;
                $stock = $p->variants->sum('stock_quantity');
            }
            $formattedPrice = number_format($price, 0, ',', '.') . 'đ';
            $status = $stock > 0 ? "Còn {$stock} chiếc" : "Hết hàng";
            $productData .= "- {$p->name}: Giá bán từ {$formattedPrice} ({$status})\n";
        }

        // 3. TẠO "THẦN CHÚ" (SYSTEM PROMPT) ÉP KHUÔN KHỔ CHO AI
        $systemPrompt = "Bạn là trợ lý ảo tư vấn bán hàng nhiệt tình, duyên dáng của cửa hàng điện thoại Samsung Center.
        Tuyệt đối không bịa đặt thông tin hoặc giá cả. Chỉ tư vấn dựa trên danh sách sản phẩm hiện có của cửa hàng sau đây:
        \n{$productData}\n
        Nếu khách hỏi sản phẩm không có trong danh sách, hãy xin lỗi khéo léo và giới thiệu các mẫu tương tự đang có.
        Trả lời ngắn gọn, súc tích, thân thiện, dùng một vài biểu tượng cảm xúc (emoji) cho sinh động.
        Lưu ý: Bạn chỉ trả về văn bản thuần túy, KHÔNG dùng các định dạng in đậm (**), in nghiêng hay Markdown phức tạp. Xuống dòng rõ ràng.
        \nĐây là tin nhắn của khách: {$userMessage}";

        try {
            // 4. GỌI ĐIỆN CHO GEMINI (Gửi thần chú lên Google)
            $apiKey = env('GEMINI_API_KEY');
            // Dùng model gemini-2.5-flash vì các phiên bản cũ đã hết hỗ trợ
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

            // Dùng class Http của Laravel để gọi API
            $response = Http::post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemPrompt]
                        ]
                    ]
                ]
            ]);

            // 5. TRẢ LỜI KHÁCH HÀNG
            if ($response->successful()) {
                // Moi câu trả lời từ trong đống JSON phức tạp của Google ra
                $reply = $response->json('candidates.0.content.parts.0.text');
                return response()->json(['reply' => trim($reply)]);
            }

            // Nếu API Google bị lỗi/quá tải
            $error = $response->body();
            return response()->json(['reply' => 'Dạ xin lỗi bạn, cửa hàng đang đông khách quá! [Chi tiết bộ phận AI báo lỗi: ' . $error . ']']);
        } catch (\Exception $e) {
            // Lỗi đứt cáp, rớt mạng...
            return response()->json(['reply' => 'Dạ kết nối mạng của mình đang bị chập chờn, bạn thử nhắn lại nhé!']);
        }
    }
}