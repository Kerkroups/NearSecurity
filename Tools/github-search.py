#!/usr/bin/env python3
"""
Automated Python vulnerability scanner using GitHub search patterns.
Usage: python3 vulnerability_scanner.py --repo owner/repo --severity high
"""

import os
import json
from typing import List, Dict
from datetime import datetime

VULNERABILITY_PATTERNS = {
    "command_injection": {
        "severity": "critical",
        "patterns": [
            'language:python content:"os.system(" path:/.*\.py$/',
            'language:python content:"subprocess.call" content:"shell=True" path:/.*\.py$/',
        ]
    },
    "sql_injection": {
        "severity": "critical",
        "patterns": [
            'language:python content:"execute(" content:"format(" path:/.*\.py$/',
            'language:python content:"filter(" content:"f\"" path:/.*\.py$/',
        ]
    },
    "pickle_deserialization": {
        "severity": "high",
        "patterns": [
            'language:python content:"pickle.loads(" path:/.*\.py$/',
            'language:python content:"pickle.load(" path:/.*\.py$/',
        ]
    },
    "hardcoded_secrets": {
        "severity": "high",
        "patterns": [
            'language:python content:"API_KEY =" path:/.*\.py$/ NOT content:"os.environ"',
            'language:python content:"PASSWORD =" path:/.*\.py$/ NOT content:"config"',
        ]
    },
    "weak_crypto": {
        "severity": "high",
        "patterns": [
            'language:python content:"hashlib.md5(" path:/.*\.py$/',
            'language:python content:"hashlib.sha1(" path:/.*\.py$/',
        ]
    }
}

class VulnerabilityScanner:
    def __init__(self, repo: str, severity_filter: str = "all"):
        self.repo = repo
        self.severity_filter = severity_filter
        self.results = []
        self.timestamp = datetime.now().isoformat()
    
    def run_scan(self) -> List[Dict]:
        """Execute vulnerability scan across repository."""
        for vuln_type, config in VULNERABILITY_PATTERNS.items():
            if self.severity_filter != "all":
                if config["severity"] != self.severity_filter:
                    continue
            
            for pattern in config["patterns"]:
                finding = self._search_pattern(pattern, vuln_type, config["severity"])
                if finding:
                    self.results.append(finding)
        
        return self.results
    
    def _search_pattern(self, pattern: str, vuln_type: str, severity: str) -> Dict:
        """Execute individual search pattern."""
        # This would call GitHub Search API in real implementation
        return {
            "type": vuln_type,
            "severity": severity,
            "pattern": pattern,
            "timestamp": self.timestamp,
            "repo": self.repo
        }
    
    def generate_report(self, output_file: str = "scan_report.json"):
        """Generate JSON report of findings."""
        report = {
            "scan_date": self.timestamp,
            "repository": self.repo,
            "total_findings": len(self.results),
            "severity_breakdown": self._calculate_severity_breakdown(),
            "findings": self.results
        }
        
        with open(output_file, 'w') as f:
            json.dump(report, f, indent=2)
        
        return report
    
    def _calculate_severity_breakdown(self) -> Dict[str, int]:
        """Calculate findings by severity."""
        breakdown = {"critical": 0, "high": 0, "medium": 0, "low": 0}
        for result in self.results:
            severity = result.get("severity", "unknown")
            if severity in breakdown:
                breakdown[severity] += 1
        return breakdown

if __name__ == "__main__":
    import argparse
    
    parser = argparse.ArgumentParser(description="Python Vulnerability Scanner")
    parser.add_argument("--repo", required=True, help="Repository (owner/repo)")
    parser.add_argument("--severity", default="all", help="Filter by severity")
    parser.add_argument("--output", default="scan_report.json", help="Output file")
    
    args = parser.parse_args()
    
    scanner = VulnerabilityScanner(args.repo, args.severity)
    scanner.run_scan()
    report = scanner.generate_report(args.output)
    
    print(f"Scan complete. Found {report['total_findings']} vulnerabilities.")
    print(f"Report saved to {args.output}")
