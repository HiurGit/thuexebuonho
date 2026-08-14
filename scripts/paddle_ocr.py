import json
import sys


def main():
    if len(sys.argv) < 2:
        print(json.dumps({
            "success": False,
            "message": "Missing image path.",
        }, ensure_ascii=False))
        return 1

    image_path = sys.argv[1]

    try:
        from paddleocr import PaddleOCR
    except Exception as exc:
        print(json.dumps({
            "success": False,
            "message": str(exc),
        }, ensure_ascii=False))
        return 1

    try:
        ocr = PaddleOCR(use_angle_cls=True, lang="vi")
        result = ocr.ocr(image_path, cls=True)
    except Exception as exc:
        print(json.dumps({
            "success": False,
            "message": str(exc),
        }, ensure_ascii=False))
        return 1

    lines = []
    for block in result or []:
        for item in block or []:
            if len(item) < 2:
                continue
            text_info = item[1]
            if isinstance(text_info, (list, tuple)) and text_info:
                text = str(text_info[0]).strip()
                if text:
                    lines.append(text)

    print(json.dumps({
        "success": True,
        "text": "\n".join(lines),
    }, ensure_ascii=False))
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
