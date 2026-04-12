#!/usr/bin/env python3
import shutil
import subprocess
import time
from pathlib import Path

from playwright.sync_api import sync_playwright


BASE_URL = "http://127.0.0.1:8000/index.php"
DEMO_DIR = Path("/workspace/demo")
RAW_DIR = DEMO_DIR / "_raw"
RAW_VIDEO = RAW_DIR / "webpage-demo.webm"
FINAL_VIDEO = DEMO_DIR / "webpage-demo.mp4"


def wait_for_server(url: str, timeout_s: float = 30.0) -> None:
    start = time.time()
    while time.time() - start < timeout_s:
        try:
            subprocess.run(
                ["curl", "-fsS", url],
                stdout=subprocess.DEVNULL,
                stderr=subprocess.DEVNULL,
                check=True,
            )
            return
        except subprocess.CalledProcessError:
            time.sleep(0.5)
    raise RuntimeError(f"Server at {url} was not reachable in {timeout_s} seconds")


def smooth_scroll(page, y: int, wait_ms: int = 1200) -> None:
    page.evaluate(f"window.scrollTo({{top: {y}, behavior: 'smooth'}})")
    page.wait_for_timeout(wait_ms)


def record_webm() -> Path:
    DEMO_DIR.mkdir(parents=True, exist_ok=True)
    if RAW_DIR.exists():
        shutil.rmtree(RAW_DIR)
    RAW_DIR.mkdir(parents=True, exist_ok=True)

    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        context = browser.new_context(
            viewport={"width": 1366, "height": 768},
            record_video_dir=str(RAW_DIR),
            record_video_size={"width": 1366, "height": 768},
        )
        page = context.new_page()

        page.goto(BASE_URL, wait_until="networkidle", timeout=60000)
        page.wait_for_timeout(1400)

        smooth_scroll(page, 650)
        smooth_scroll(page, 1450)
        smooth_scroll(page, 2300)

        page.click("#btnGitHub")
        page.wait_for_timeout(1600)
        page.keyboard.press("Escape")
        page.wait_for_timeout(500)

        page.click("#btnLinkedIn")
        page.wait_for_timeout(1400)
        page.keyboard.press("Escape")
        page.wait_for_timeout(600)

        page.click('a[href="#contact"]')
        page.wait_for_timeout(1200)

        page.fill("#name", "Demo User")
        page.wait_for_timeout(200)
        page.fill("#email", "demo@example.com")
        page.wait_for_timeout(200)
        page.fill("#phone", "+49 123 4567890")
        page.wait_for_timeout(200)
        page.fill("#message", "Hallo! Das ist eine Demo-Nachricht fuer das Video.")
        page.wait_for_timeout(300)

        page.click("button.form-submit")
        page.wait_for_selector("#contactResponse", state="visible", timeout=10000)
        page.wait_for_timeout(1600)

        smooth_scroll(page, 0, wait_ms=1000)
        page.wait_for_timeout(1200)

        video = page.video
        context.close()
        browser.close()

        if video is None:
            raise RuntimeError("No Playwright video artifact was created")

        captured = Path(video.path())
        if not captured.exists():
            raise RuntimeError(f"Expected captured webm not found at {captured}")

        if RAW_VIDEO.exists():
            RAW_VIDEO.unlink()
        shutil.move(str(captured), RAW_VIDEO)
        return RAW_VIDEO


def transcode_to_mp4(input_webm: Path, output_mp4: Path) -> None:
    if output_mp4.exists():
        output_mp4.unlink()

    cmd = [
        "ffmpeg",
        "-y",
        "-i",
        str(input_webm),
        "-c:v",
        "libx264",
        "-pix_fmt",
        "yuv420p",
        "-preset",
        "medium",
        "-crf",
        "23",
        "-movflags",
        "+faststart",
        str(output_mp4),
    ]
    subprocess.run(cmd, check=True)


def main() -> None:
    wait_for_server(BASE_URL)
    webm_path = record_webm()
    transcode_to_mp4(webm_path, FINAL_VIDEO)
    print(f"Created demo video: {FINAL_VIDEO}")


if __name__ == "__main__":
    main()
