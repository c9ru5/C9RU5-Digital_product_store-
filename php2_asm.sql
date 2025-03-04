-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 23, 2025 lúc 04:50 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `php2_asm`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`) VALUES
(3, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `icon`) VALUES
(1, 'Giải trí', 'bi bi-controller'),
(2, 'Làm việc', 'bi bi-briefcase'),
(3, 'Học tập', 'bi bi-mortarboard'),
(4, 'Game Steam', 'bi bi-steam'),
(5, 'Edit ảnh - video', 'bi bi-camera-video'),
(6, 'Windows, Office', 'bi bi-windows'),
(7, 'Google Drive', 'bi bi-google'),
(8, 'Steam Wallet', 'bi bi-wallet2'),
(9, 'Diệt Virus', 'bi bi-shield-check'),
(16, 'Xbox, iTunes Gift Card', 'bi bi-controller');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `detail_carts`
--

CREATE TABLE `detail_carts` (
  `id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `detail_orders`
--

CREATE TABLE `detail_orders` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `detail_orders`
--

INSERT INTO `detail_orders` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 2, 2, 1),
(2, 2, 9, 2),
(3, 2, 15, 3),
(4, 3, 2, 1),
(5, 3, 9, 2),
(6, 3, 15, 3),
(7, 4, 2, 1),
(8, 4, 9, 2),
(9, 4, 15, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `value` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status`, `date_created`, `value`) VALUES
(2, 19, 0, '2025-02-22 21:45:26', 1000000),
(3, 19, 2, '2025-02-22 21:45:48', 1000000),
(4, 19, 0, '2025-02-22 21:46:04', 1000000),
(7, 19, 2, '2025-01-23 22:15:19', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `product_description` varchar(5000) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `sales` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `discount_percent`, `image`, `quantity`, `product_description`, `genre`, `sales`, `category_id`) VALUES
(2, 'Black Myth: Wukong - Thuê game (1 ngày)', 1299000, 93, 'sp1.png', 11, 'Black Myth: Wukong là một game hành động nhập vai (RPG) lấy cảm hứng từ thần thoại Trung Quốc. Câu chuyện dựa trên Tây Du Ký, một trong Tứ Đại Danh Tác của văn học Trung Quốc. Bạn sẽ vào vai Nhân Vật Được Định Mệnh Chọn Lựa, đối mặt với những thách thức và kỳ quan phía trước, khám phá sự thật bị che giấu dưới tấm màn của một huyền thoại huy hoàng từ quá khứ.', 'Action, Adventure, RPG', 0, 4),
(3, 'Netflix Premium 1 tháng - Tài khoản', 260000, 66, 'sp2.png', 22, 'Tài khoản Netflix Premium có rất nhiều tính năng hấp dẫn như:<br>- Xem phim chất lượng 4k, chất lượng đường truyền nhanh.<br>- Hỗ trợ xem trên các thiết bị PC/TV/Mobile.<br>- Tải phim để có thể xem ngoại tuyến.<br>- Nội dung đa dạng, xem phim đầy đủ phụ đề tiếng Việt.', 'App, Giải trí, Xem phim', 0, 1),
(4, 'Spotify Premium 1 năm - Gia hạn chính chủ', 708000, 51, 'sp3.png', 2, 'Spotify là ứng dụng nghe nhạc bản quyền nổi tiếng trên toàn thế giới. Spotify có hàng triệu bản nhạc từ tất cả mọi nơi trên thế giới bao gồm cả các bài hát ở Việt Nam. <br> Chất lượng nhạc của Spotify luôn đạt mức cao và tốc độ tải dữ liệu nhanh.<br> Spotify có thể đăng nhập được ở trên rất nhiều thiết bị khác nhau như: Điện thoại, Máy tính, Máy tính bảng, Tivi thậm chí cả trên Ô tô. Giúp người dùng đồng bộ và xây dựng các album riêng cho mình một cách cực kì dễ dàng và hiệu quả. <br> Trong các cuộc bình chọn, Spotify luôn được đánh giá là một trong những ứng dụng nghe nhạc tốt nhất.', 'App, Giải trí, Spotify, Nghe nhạc', 0, 1),
(5, 'Zoom Pro ~ 1 tháng (28 ngày) - Gói nâng cấp', 350000, 40, 'sp4.png', 4, 'Zoom hay Zoom Cloud Meetings là phần mềm họp hội nghị trực tuyến đa điểm hoạt động trên môi trường internet.<br>- Các ứng dụng như Skype, facebook, zalo cũng có thể gọi nhóm được nhưng tính năng sẽ rất bị hạn chế.<br>- Zoom ra đời là giải pháp để thay đổi việc khách hàng đầu tư một hệ thống hội nghị truyền hình dạng thiết bị cứng tốn rất nhiều chi phí đầu tư và vận hành, không linh hoạt.<br>- Zoom có những tính năng vượt trội so với các phần mềm khác.<br>- Trong môi trường sư phạm, Zoom Meetings thường được ứng dụng để giảng dạy, hội họp, hội thảo trực tuyến với khả năng cho phép kết nối hàng trăm người một lúc.', 'App, Làm việc, Học tập', 0, 2),
(6, 'Windows 10 Professional - CD Key', 400000, 28, 'sp5.png', 5, 'Hướng dẫn kích hoạt key Retail bản quyền cho Windows 10 <br>**Lưu ý: <br>- Trước khi add code thì máy bạn phải cài Win 10 Pro và chưa Crack.<br>- Chỉ sử dụng trên một máy và một tài khoản Microsoft. Các lần cài win sau tự động active theo main của máy và tài khoản này.<br>Bước 1<br>Nhấp vào biểu tượng Windows ở góc trái trên thanh Task bar để mở Start Menu. Tại đây, các bạn chọn vào Settings (có biểu tượng hình bánh răng) để mở phần tùy chọn chung trên thiết bị.<br>Bước 2<br>- Tại đây các bạn chọn Update & Security > và chọn vào mục Activation. Bạn có thể nhập key Win 10 tại đây. <br>- Bạn click “Change product key” và nhập key Win 10 vào là xong. Lúc này Win 10 sẽ được kích hoạt trên máy tính của bạn.', 'Windows, Làm việc, Microsoft', 0, 6),
(7, 'YouTube Premium + YouTube Music 1 năm', 6720000, 93, 'sp6.png', 7, 'Với YouTube Premium, bạn có thể xem hàng triệu video không có quảng cáo. Quảng cáo bao gồm cả quảng cáo trước và trong video cũng như quảng cáo biểu ngữ, quảng cáo đi kèm kết quả tìm kiếm và quảng cáo lớp phủ trên video. Bạn vẫn có thể xem quảng cáo hoặc thương hiệu nhúng trong nội dung của người sáng tạo mà YouTube không kiểm soát. <br>Video không có quảng cáo được hỗ trợ trên tất cả các thiết bị và nền tảng mà bạn có thể đăng nhập bằng tài khoản Google, kể cả trên TV thông minh/máy chơi trò chơi tương thích và các ứng dụng YouTube, YouTube Âm nhạc, YouTube Gaming và YouTube Kids dành cho thiết bị di động nếu các ứng dụng này có ở địa điểm của bạn.', 'App, Giải trí, Youtube', 0, 1),
(8, 'Discord Nitro 3 tháng - Đăng kí lần đầu', 690000, 75, 'sp7.png', 8, 'Chương trình khuyến mãi từ Discord và đối tác dành cho tài khoản chưa từng kích hoạt Nitro, nhận 3 tháng sử dụng Discord Nitro. Divine Shop hỗ trợ người dùng không có thẻ thanh toán quốc tế để nhận ưu đãi với mức phí chỉ 175.000đ. <br>Khách hàng điền thông tin tài khoản Discord của mình và thanh toán sản phẩm này, Divine Shop sẽ hoàn tất việc kích hoạt gói cước cho bạn', 'App, Làm việc', 0, 2),
(9, 'Canva Pro 1 năm - Gia hạn chính chủ', 1500000, 80, 'sp8.png', 9, 'Canva là một nền tảng thiết kế mạnh mẽ và linh hoạt, được thiết kế để đáp ứng mọi nhu cầu sáng tạo của bạn. Với Canva Pro, bạn có thể truy cập vào một thư viện tài nguyên sáng tạo vô cùng đa dạng, bao gồm hàng triệu hình ảnh và video chất lượng cao, giúp làm phong phú hơn mọi thiết kế của bạn.', 'App, Làm việc, Thiết kế, Edit Ảnh Video', 0, 2),
(10, 'S.T.A.L.K.E.R.: Shadow of Chernobyl (CD-Key)', 188000, 37, 'sp9.jpg', 10, '\r\nIn 1986, the world\'s worst nuclear disaster occurred at the Chernobyl Nuclear Power Plant. Soviet authorities established an \'Exclusion Zone\' around, but a second explosion hit the reactor in 2006, creating The Zone as we know it – dangerous place, filled with mutated creatures, deadly radiation, and a strange, anomalous energy. The Zone was cordoned off by the military, who would shoot on sight anyone foolish enough to get inside. <br> <br>\r\nYear 2012. The Zone is still a dangerous place and a threat to all mankind. Mercenaries, bounty hunters and explorers ventured further and further into the heart of the Zone driven by reports of strange \'artifacts\' imbued with anomalous energy. To sell them on the black market or trying to find the \'truth\' behind the Zone. Whatever their motivation, over time these individuals - Scavengers, Trespassers, Adventurers, Loners, Killers, Explorers and Robbers - have become known as S.T.A.L.K.E.R.s.\r\n', 'Action, RPG', 0, 4),
(11, 'S.T.A.L.K.E.R.: Call of Pripyat (CD-Key)', 188000, 37, 'sp10.jpg', 10, 'S.T.A.L.K.E.R.: Call of Pripyat (STALKER: Call of Pripyat) là một game bắn súng góc nhìn thứ nhất - sống sót kinh dị được phát triển bởi GSC Game World. Đây là game thứ ba phát hành trong seri S.T.A.L.K.E.R., sauS.T.A.L.K.E.R.: Shadow of Chernobyl và S.T.A.L.K.E.R.: Clear Sky,Game tái tạo lại nguyên mẫu thực của thành phố Pripyat, đường sắt, nhà ga Yanov, nhà máy \"Jupiter”, V.v với một câu chuyện mới, nhân vật mới hấp dẫn hơn, tăng cường hệ thống các nhiệm vụ phụ, quái vật mới và một khu vực mới hoàn toàn - byurer chimera.CoP vẫn kết hợp lối chơi bắn súng góc nhìn người thứ nhất với một chút tính nhập vai cùng 3 bản đồ chính là Creek, Jupiter và Pripyat. Tùy thời điểm, người chơi có thể dịch chuyển từ bản đồ này sang bản đồ khác miễn sao có đủ lộ phí đưa cho người dẫn đường. Game lại một lần nữa đưa người chơi xâm nhập vùng nhiễm xạ chết người xung quanh nhà máy hạt nhân Chernobyl.', 'Action, RPG', 0, 4),
(12, 'Shapr3d 14 ngày - Tài khoản', 500000, 92, 'sp11.png', 10, 'Shapr3D là phần mềm thiết kế 3D tiên tiến, mang lại trải nghiệm sáng tạo mượt mà và dễ dàng trên iPad, Mac, và Windows. Với giao diện trực quan và khả năng kết hợp bút Apple Pencil, Shapr3D là lựa chọn lý tưởng cho các kiến trúc sư, nhà thiết kế sản phẩm, kỹ sư, và nghệ sĩ 3D muốn tạo ra các bản vẽ kỹ thuật chính xác và mô hình 3D sống động.', 'App, Làm việc, New', 0, 2),
(13, 'NBA 2K24 Kobe Bryant Edition - CD Key', 1000000, 57, 'sp12.jpg', 10, 'Grab your squad and experience the past, present, and future of hoops culture in NBA 2K24. Enjoy loads of pure, unadulterated action and limitless personalized MyPLAYER options in MyCAREER. Collect an impressive array of legends and build your perfect lineup in MyTEAM. Feel more responsive gameplay and polished visuals while playing with your favorite NBA and WNBA teams in PLAY NOW. <br>MAMBA MOMENTS <br>Channel your inner-Mamba Mentality as you recreate Kobe’s most dominant and captivating performances during his rise to global superstardom. Revisit his early career triumphs as a young phenom, and progress through his transcendent journey from elite scorer to one of the greatest players ever.<br>HOOP IN PARADISE <br>Make your mark on a scenic, coastal Neighborhood rich with postcard-esque views and blistering competition. Use the revamped player builder to create a MyPLAYER that suits your skillset, so you can play to your strengths and get the most out of the updated Badge system. Explore cliffside terrain, complete a new set of streamlined quests, and take on rival players in the ultimate MyCAREER backdrop.<br>MANAGE YOUR MyTEAM <br>The classic card-collecting mode is back and loaded with endless hours of customizable fun. Draw from the past and present using today’s All-Stars and all-time legends to form a squad capable of dominating single player and multiplayer modes. MyTEAM features a collection of innovative improvements, including an all-new salary cap mode, while maintaining its signature competitive feel. <br>MAKE YOUR MOVES <br>Enjoy the most authentic gameplay yet, with an emphasis on seamless mechanics and attention to detail. Showcase your deep arsenal of moves with revamped interior defense and dribble combo controls for more rewarding skill-based actions and effectiveness.', 'Simulation, Sports, New', 10, 4),
(15, 'CapCut Pro 1 Tháng - Tài khoản', 210000, 53, 'sp13.png', 10, 'Capcut là ứng dụng cho phép người dùng có thể chỉnh sửa video miễn phí trên điện thoại, có mặt trên hệ điều hành Android, iOS. Capcut có một số tính năng tiện lợi, phục vụ cho người dùng chỉnh sửa video ở mức cơ bản. Ứng dụng này ngày càng được nhiều người ưa thích, sử dụng để biên tập các video trên Tiktok, Instagram,… <br>\r\nCapcut được thiết kế đơn giản với bố cục rõ ràng, dễ sử dụng. Chỉ cần một vài thao tác cơ bản là bạn có thể edit video nhanh chóng trên capcut. <br>\r\nCác tính năng của Capcut Pro <br>\r\n- Mở khóa tất cả các tính năng và tài liệu chuyên nghiệp.<br>\r\n- Chỉnh sửa được các mẫu cao cấp.<br>\r\n- Nhận 100GB dung lượng Cloud.', 'Thiết kế, làm việc, Edit Ảnh Video, new', 0, 2),
(16, 'ChatGPT Plus 20$ 1 tháng (GPT-4o) - Tài khoản Share', 510000, 50, 'sp14.png', 10, 'Khám phá trí tuệ AI vượt trội với ChatGPT Plus - Tiết kiệm chi phí với hình thức Tài khoản Share\r\n<br>\r\nChatGPT Plus là bản nâng cấp cao cấp cho trình tạo văn bản trí tuệ nhân tạo (AI) phổ biến của OpenAI – ChatGPT, nâng tầm trải nghiệm với những tính năng nâng cao mới.<br>\r\n\r\nTối ưu chi phí với hình thức Tài khoản Share <br>\r\nVới sản phẩm này, bạn có thể tiết kiệm chi phí mà vẫn trải nghiệm trọn bộ tính năng với thời hạn 1 tháng.<br>\r\n\r\nYêu cầu xếp hàng đợi ưu tiên hơn<br>\r\nCác yêu cầu được xếp vào hàng chờ cao hơn, thời gian phản hồi cũng nhanh hơn bản chatgpt free. Người dùng sẽ không gặp phải lỗi quá tải người dùng hay lỗi máy chủ chatgpt quá tải.<br>\r\n\r\nTruy cập trong thời gian cao điểm không bị lỗi<br>\r\nNgười dùng phiên bản ChatGPT miễn phí rất khó truy cập trong giờ cao điểm với số lượng người sử dụng cao, thường xuyên f5 lại trình duyệt mới sử dụng được chatgpt. Lỗi này sẽ được khắc phục hoàn toàn khi bạn nâng cấp lên phiên bản chatgpt Plus. Trong thời gian số lượng người sử dụng nhiều nhất, OpenAI sẽ ưu tiên những tài khoản ChatGPT Plus đầu tiên.<br>\r\n\r\nTrải nghiệm những tính năng mới<br>\r\nHiện tại tài khoản ChatGPT Plus có thể kích hoạt và sử dụng Model GPT-4o hiện đại và thông minh hơn<br>\r\n\r\nNhiều câu trả lời hơn<br>\r\nPhiên bản ChatGPT Plus cung cấp nhiều đáp án hơn, tối đa 3 đáp án cho người dùng tham khảo. Vì vậy, bạn có thêm nhiều lựa chọn về nội dung mà chatbot AI này cung cấp.', 'Openai, chatgpt, tài khoản, study, work, học tập, làm việc, ai, ai chat bot', 0, 2),
(17, 'Dead by Daylight', 340000, 60, 'sp15.jpg', 10, 'Dead by Daylight là 1 game nhiều người chơi (1 vs 4). 1 tựa game horror survivor , Dead by Daylight đem lại cho bạn những cảm giác như trong những phim kinh dị mỹ đình đám 1 thời.Với mỗi lần tiếng tim đập,hoặc tiếng âm nhạc dồn dập là 1 lần bạn thót tim và chạy không quay đầu lại.<br>Trong game,bạn có thể vào vai 1 kẻ giết người bệnh hoạn mang trong mình 1 sứ mệnh duy nhất là giết hết 4 kẻ đang cố thắp sáng vườn nhà bạn.Bạn có thể treo chúng lên những chiếc giá treo đang đợi sẵn hoặc là bỏ mặc cho chảy máu đến chết.Với những kĩ năng được mở ra nhờ điểm thưởng bạn có được sẽ giúp ích rất nhiều trong việc truy đuổi 4 kẻ đang phá rối khu vườn của bạn.Hiện tại nhà phát triển game đã tạo ra 5 killers : THE WRAITH , THE HILLBILLY , THE TRAPPER , THE NURSE VÀ NHÂN VẬT MỚI NHẤT MICHAEL MYERS. Mỗi killer có 1 khả năng đặc biệt riêng để truy đuổi những người sống sót.Với kiểu chơi ở góc nhìn thứ nhất,bạn sẽ thật sự nhập vai 1 cách tuyệt vời…<br>Nếu muốn trải nghiệm cảm giác làm nhân vật chính trong những bộ phim kinh dị có những kẻ giết người bá đạo như Friday the 13th , Halloween ,... thì bạn nên chọn PLAY AS SURVIVORS. Nhiệm vụ của bạn là tránh bị bắt, bị tra tấn và bị giết...Hoặc bạn có thể sửa chữa 5 máy phát điện và mở 1 trong 2 chiếc cửa và trốn thoát. Bạn có thể chọn 1 cách khác là đợi là người cuối cùng và tìm chiếc cửa sập mở ra.Khi làm survivors bạn sẽ đc chơi ở góc nhìn thứ 3,đây sẽ là 1 lợi thế khi bạn có thể vừa di chuyển vừa quan sát xung quanh mình.\r\n\r\n', 'Action', 0, 4),
(18, 'Sea of Thieves', 890000, 10, 'sp16.jpg', 10, 'Sau một khoảng thời gian chật vật trong việc tìm kiếm những nội dung để làm mới mình, Sea of Thieves đã có một màn quay trở lại thú vị với một bản cập nhật “khủng” tập trung rất mạnh về các chế độ chơi và phần cốt truyện. Không chỉ dừng ở đó, nhà sản xuất còn tiếp tục mang đến cho tựa game này nhiều nội dung mới cũng như các sự kiện trong các bản cập nhật giới hạn theo tháng.<br>Sea Of Thieves đã chính thức khởi động một sự kiện có thời hạn với tên gọi Black Powder Stashes đồng thời cũng bắt đầu kế hoạch phát hành các nội dung hàng tháng cho tựa game đa người chơi về thế giới hải tặc này. Hiện tại, bản cập nhật sư kiện này đã có sẵn để tải xuống và sẽ mang đến rất nhiều những thành trình thú vị khác cho người chơi. Bản câp nhập này bao gồm sáu cốt truyện khác nhau với mỗi cốt truyện sẽ mang người chơi đến một địa khác nhau trên bản đồ, cùng với đó là hai thử thách rất khó khăn buộc rất nhiều đội chơi phải cùng đi chung một tuyến đường. Điều đó có thể mang đến những cuộc “đụng chạm” bất ngờ cho dù cuộc viễn chinh của bạn chỉ với mục đích tìm kiếm, hay vi vu lòng vòng trên bản đồ và lấy đi càng nhiều thùng nổ càng tốt.<br>Các vật phẩm như Thùng Thuốc Súng hay các Thùng Vật Phẩm bạn thu nhận được đều có thể được bán lại cho các “công ty thương mại” mà bạn chọn để kiếm phần thưởng dưới dạng tăng điểm kinh nghiệm tương ứng. Không chỉ vậy, những người chơi đạt danh hiệu Pirate Legends, đều có thể nhận được điểm danh tiếng Athena’s Fortune từ các nhân vật bí ẩn, hay chính xác hơn là các nhân vật phụ bạn có thể gặp mỗi khi đến Tavern và Outpost. Ngoài ra, sự kiện có thời hạn này cũng giới thiệu đến người chơi một chế độ trao thưởng mới là Mercenary Commendations mang đến cho người chơi nhiều phần thưởng như tiền và các danh hiệu các cũng như một số hạng mục trang trí đi kèm. Và phần thưởng này chỉ được trao khi bạn hoàn thành các cuộc hải trình của mình.<br>Bản cập nhật mới cũng sẽ phân phát rải rác các loại ngọc Mermaid Gems khắp thế giới và có thể xuất hiện ở bất kì hang động hay xác tàu nào như cách mà Kraken và Megalodon xuất hiện. Điều này giúp người chơi dễ dàng hơn so với việc tìm kiếm các tượng Mermaid Statue, đồng thời chỉnh sửa rất nhiều lỗi, thực hiện cân bằng game, cải thiện khả năng truy cập và giới thiệu nhiều tính năng lớn nhỏ khác.\r\n', 'Action, Adventure', 0, 4),
(19, 'Deus Ex: Game of the Year Edition', 115000, 86, 'sp17.jpg', 10, 'Thế giới vào năm 2052 là một nơi nguy hiểm và hỗn loạn. Những kẻ khủng bố hoạt động công khai - giết hàng nghìn người; ma túy, bệnh tật và ô nhiễm giết chết nhiều hơn. Các nền kinh tế trên thế giới gần như sụp đổ và khoảng cách giữa những người giàu có và những người nghèo tuyệt vọng ngày càng rộng hơn. Tệ nhất là, một âm mưu lâu đời nhằm vào sự thống trị thế giới đã quyết định rằng thời điểm thích hợp để xuất hiện từ trong bóng tối và nắm quyền kiểm soát.<br>Các tính năng chính:<br>\r\n- Nhập vai thực sự từ góc nhìn thứ nhất, 3D nhập vai. Trò chơi bao gồm hành động, tương tác nhân vật và giải quyết vấn đề.<br>\r\nVị trí thực tế, dễ nhận biết. Nhiều địa điểm được xây dựng dựa trên bản thiết kế thực tế của những địa điểm có thật trong bối cảnh tương lai gần.<br>\r\n- Một trò chơi chứa nhiều người hơn là quái vật. Điều này tạo ra sự đồng cảm với các nhân vật trong game và nâng cao tính hiện thực của thế giới game.<br>\r\n- Hệ thống phát triển nhân vật phong phú: Kỹ năng, cường hóa, lựa chọn vũ khí và vật phẩm cùng nhiều giải pháp cho các vấn đề đảm bảo rằng không có hai người chơi nào kết thúc trò chơi với những nhân vật giống nhau.<br>\r\n- Nhiều giải pháp cho các vấn đề và lựa chọn phát triển nhân vật đảm bảo trải nghiệm trò chơi đa dạng. Nói chuyện, chiến đấu hoặc sử dụng các kỹ năng để vượt qua các chướng ngại vật khi trò chơi tự điều chỉnh theo phong cách chơi của bạn.<br>\r\n- Cốt truyện mạnh mẽ: Được xây dựng dựa trên các thuyết âm mưu \"có thật\", các sự kiện hiện tại và những tiến bộ được mong đợi trong công nghệ. ', 'Action', 0, 4),
(20, 'Deus Ex: The Fall', 165000, 50, 'sp18.jpg', 10, 'TỔNG QUÁT :<br>\r\nDeus Ex: The Fall lấy bối cảnh vào năm 2027– kỷ nguyên vàng cho khoa học, công nghệ và nâng cao con người, nhưng cũng là thời điểm có nhiều chia rẽ xã hội và âm mưu toàn cầu. Các tập đoàn hùng mạnh đã giành quyền kiểm soát từ các chính phủ và chỉ huy việc cung cấp thuốc cần thiết cho con người tăng cường để tồn tại.\r\n<br>\r\nTrong sự hỗn loạn này, Ben Saxon, một cựu lính đánh thuê SAS của Anh, người đã trải qua quá trình tăng cường thể chất, đang tuyệt vọng về sự thật đằng sau âm mưu ma túy. Bị phản bội bởi những người chủ quân sự tư nhân của anh ta, Tyrant, không chỉ cuộc sống của anh ta gặp nguy hiểm mà đối với tất cả những người được tăng cường biến đổi, thời gian đang dần cạn kiệt…<br>\r\nĐược phát triển với sự cộng tác của nhóm DEUS EX: HUMAN REVOLUTION® ban đầu tại Eidos-Montréal và N-Fusion ; Deus Ex: The Fall bao gồm đầy đủ Steam Achievements, cấu hình điều khiển Chuột & Bàn phím và hỗ trợ Control Pad.<br>\r\nĐẶC TRƯNG:<br>\r\nĐây là một phiên bản gốc của trải nghiệm DEUS EX: THE FALL, được phát hành lần đầu tiên trên iOS và Android vào năm 2013 - trò chơi hành động, tàng hình, hack và xã hội. Một câu chuyện tiền truyện của Deus Ex: Human Revolution được xây dựng dựa trên vũ trụ DEUS EX. Chiến đấu để tồn tại trong một âm mưu toàn cầu.', 'Action, Adventure, RPG', 0, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 2,
  `balance` double NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`, `role`, `balance`, `status`) VALUES
(1, 'ntv', 'vietnguyen.141105@gmail.com', '123', 'evelyn.jpg', 0, 0, 1),
(18, 'ntv1', 'nguyentheviet.141105@gmail.com', '123', '', 1, 0, 1),
(19, 'ntv2', 'theviet.141105@gmail.com', '123', '', 2, 0, 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_FK_users` (`user_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `detail_carts`
--
ALTER TABLE `detail_carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_carts_FK_carts` (`cart_id`),
  ADD KEY `detail_carts_FK_products` (`product_id`);

--
-- Chỉ mục cho bảng `detail_orders`
--
ALTER TABLE `detail_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_orders_FK_orders` (`order_id`),
  ADD KEY `detail_orders_FK_products` (`product_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_FK_users` (`user_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_categorys` (`category_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `detail_carts`
--
ALTER TABLE `detail_carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT cho bảng `detail_orders`
--
ALTER TABLE `detail_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_FK_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `detail_carts`
--
ALTER TABLE `detail_carts`
  ADD CONSTRAINT `detail_carts_FK_carts` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`),
  ADD CONSTRAINT `detail_carts_FK_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `detail_orders`
--
ALTER TABLE `detail_orders`
  ADD CONSTRAINT `detail_orders_FK_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `detail_orders_FK_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_FK_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_categorys` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
